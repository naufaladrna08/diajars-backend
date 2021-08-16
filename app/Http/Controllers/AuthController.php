<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;

class AuthController extends Controller {
  public $auth;

  public function __construct(JWTAuth $auth) {
    $this->auth = $auth;
  }

  public function loginWithToken(Request $r) {
    $data = [];

    if ($r->input('token')) {
      $this->auth->setToken($r->input('token'));

      $user = $this->auth->authenticate();
      if ($user) {
        $data = [
          'code'    => 200,
          'status'  => 'Success',
          'message' => 'Data ditemukan',
          'data'    => [
            'user'  => $r->user(), 
            'token' => $r->token
          ]
        ];

	      return response()->json($data);
      }
    }
  }

  protected function respondWithToken($token) {
    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      // 'expires_in' => auth()->factory()->getTTL() * 60
    ]);
  }
}