<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepositoryImpl implements UserRepository
{
  private $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function save($data)
  {
    $user = new $this->user;

    $user->email = $data['email'];
    $user->password = Hash::make($data['password']);
    $user->name = $data['name'];

    $user->save();

    return $user;
  }
}
