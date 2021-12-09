<?php

namespace App\Services\User;

use App\Repositories\User\EloquentUserRepositoryImpl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthServiceImpl implements AuthService
{

  private $userRepository;

  public function __construct(EloquentUserRepositoryImpl $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function register($data)
  {

    $validate = Validator::make($data, [
      "email" => "required|email|unique:users",
      "password" => "required",
      "name" => "required|string",
    ]);

    if ($validate->fails()) throw new \InvalidArgumentException($validate->errors()->first());

    $result = $this->userRepository->save($data);

    return $result;
  }

  public function login($data)
  {
    $validate = Validator::make($data, [
      "email" => "required|email|string",
      "password" => "required",
    ]);

    if ($validate->fails()) throw new \InvalidArgumentException($validate->errors()->first());

    $result = $this->userRepository->findByEmail($data['email']);
    if (!$result) throw new \InvalidArgumentException("Wrong email or password");

    $token = Auth::attempt($data);

    return $token;
  }
}
