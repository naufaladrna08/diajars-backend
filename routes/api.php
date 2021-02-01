<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('guest')->group(function () {
	# User
	Route::post('login', [UserController::class, 'login']);
	Route::post('register', [UserController::class, 'register']);
	Route::post('upload_photo', [UserController::class, 'upload_photo']);

  # Guru
  Route::post('guru/murid', [UserController::class, 'murid_by_class']);
  Route::post('guru/check_class_state', [KelasController::class, 'check_class_state']);
  Route::post('guru/get_materi', [KelasController::class, 'get_materi']);
  Route::post('guru/get_games', [KelasController::class, 'get_games']);

  # Murid
  Route::post('murid/get_statistic', [UserController::class, 'get_statistic']);

  # Google OAuth2
  Route::get('auth/google', [SocialLoginController::class, 'redirect_to_google']);
  Route::get('auth/google/callback', [SocialLoginController::class, 'google_callback']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::group(['middleware' => 'jwt.auth'], function() {
  Route::get('/me', [UserController::class, 'index']);

  Route::get('/logout', [UserController::class, 'logout']);
});