<?php

namespace App\Repositories\User;

interface UserRepository
{
  public function save($data);
  public function findByEmail($email);
}
