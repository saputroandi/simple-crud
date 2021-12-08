<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\UserServiceImpl;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{

  private $userService;

  public function __construct(UserServiceImpl $userService)
  {
    $this->userService = $userService;
  }

  public function register(Request $request)
  {
    $data = $request->only(["email", "password", "name"]);

    $result = ["status" => 200];

    try {
      $result["data"] = $this->userService->saveUserData($data);
    } catch (Exception $e) {
      $result = [
        "status" => 500,
        "error" => $e->getMessage()
      ];
    }

    return response()->json($result, $result["status"]);
  }
}
