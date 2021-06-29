<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\NilaiController;

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

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

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
  
  # Materi
  Route::post('materi/tambah_tugas', [KelasController::class, 'add_task']);
  Route::post('materi/lihat_tugas', [KelasController::class, 'get_task']);
  Route::post('materi/detail_tugas', [KelasController::class, 'get_task']);
  Route::post('materi/hapus_tugas', [KelasController::class, 'delete_task']);

  # Murid
  Route::post('murid/get_statistic', [UserController::class, 'get_statistic']);
  Route::post('murid/get_data', [UserController::class, 'get_murid_by_id']);
  Route::post('murid/get_class', [KelasController::class, 'student_get_class']);

  Route::post('game/test/tambah_nilai', [NilaiController::class, 'tambah_nilai']);

  # Google OAuth2
  Route::get('auth/google', [SocialLoginController::class, 'redirect_to_google']);
  Route::get('auth/google/callback', [SocialLoginController::class, 'google_callback']);

  # Games
  Route::post('testapi', [NilaiController::class, 'test_nilai']);
  Route::post('game/mengenal_angka', [NilaiController::class, 'mengenal_angka']);
  Route::post('game/mengenal_huruf', [NilaiController::class, 'mengenal_huruf']);
  Route::post('game/simpan_gambar', [NilaiController::class, 'simpan_gambar']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::group(['middleware' => 'jwt.auth'], function() {
  Route::get('/me', [UserController::class, 'index']);

  Route::get('/logout', [UserController::class, 'logout']);
});