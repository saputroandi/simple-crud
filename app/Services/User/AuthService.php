<?php

namespace App\Services\User;

interface AuthService
{
  public function register($data);
  public function login($data);
}
