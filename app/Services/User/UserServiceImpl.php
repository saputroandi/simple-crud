<?php

namespace App\Services\User;

use App\Repositories\User\EloquentUserRepositoryImpl;
use Illuminate\Support\Facades\Validator;

class UserServiceImpl implements UserService
{

  private $userRepository;

  public function __construct(EloquentUserRepositoryImpl $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function saveUserData($userData)
  {

    $validate = Validator::make($userData, [
      "email" => "required|email|unique:users",
      "password" => "required",
      "name" => "required|string",
    ]);

    if ($validate->fails()) throw new \InvalidArgumentException($validate->errors()->first());

    $result = $this->userRepository->save($userData);

    return $result;
  }
}
