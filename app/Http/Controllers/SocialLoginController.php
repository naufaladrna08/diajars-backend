<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TableSosialMedia;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\JWTAuth;

class SocialLoginController extends Controller {
	protected $auth;

	public function __construct(JWTAuth $auth) {
		$this->auth = $auth;
	}

  public function redirect_to_google() {
  	// dd(['s' => env('JWT_SECRET')]);
    return Socialite::driver('google')->stateless()->redirect();
  }

  public function google_callback() {
    try {
  	  $serviceUser = Socialite::driver('google')->stateless()->user();
    } catch (\Exception $e) {
      return redirect(env('CLIENT_BASE_URL') . '/auth/social-callback?error');
    }
   	
    $email = $serviceUser->getEmail();
    $id    = $serviceUser->getId();   
      
    if (User::where('email', $email)->count() > 0) {
    	$user   = User::where('email', $email)->first();
    	$social = TableSosialMedia::where('uid', $user['id'])->first();

    	if ($social['social_id'] == null) {
    		TableSosialMedia::where('uid', $user['id'])->update([
    			'social_id' => $id
    		]);

   	 		return redirect(env('CLIENT_BASE_URL') . '/auth/social-callback?token=' . $this->auth->fromUser($user));
    	} else {
    		return redirect(env('CLIENT_BASE_URL') . '/auth/social-callback?token=' . $this->auth->fromUser($user));
    	}
    } else {
      return redirect(env('CLIENT_BASE_URL') . '/chooserole');
    }
  }
}

