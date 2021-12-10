<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\AuthServiceImpl;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

  private $authService;

  public function __construct(AuthServiceImpl $authService)
  {
    $this->authService = $authService;
    // $this->middleware('auth:api', ['except' => ['login', 'register']]);
  }

  public function register(Request $request)
  {
    $data = $request->only(["email", "password", "name"]);

    $result = ["status" => 200];

    try {
      $result["data"] = $this->authService->register($data);
    } catch (Exception $e) {
      $result = [
        "status" => 500,
        "error" => $e->getMessage()
      ];
    }

    return response()->json($result, $result["status"]);
  }

  public function login(Request $request)
  {
    $data = $request->only(["email", "password"]);

    $result = ["status" => 200];

    try {
      $result["token"] = $this->authService->login($data);
      // $result["user"] = Auth::user();

      // if (!$result["token"] == false) response()->json(['message' => 'Unauthorized'], 401);
    } catch (Exception $e) {
      $result = [
        "status" => 500,
        "error" => $e->getMessage()
      ];
    }

    return response()->json($result, $result["status"]);
  }
}
