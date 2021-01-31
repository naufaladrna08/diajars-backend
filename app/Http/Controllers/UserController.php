<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RelasiKelas;
use App\Models\TableSosialMedia;
use App\Models\Kelas;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\JWTAuth;
use Socialite;

class UserController extends Controller {
	protected $auth;
	protected $redirectTo = '';

	public function __construct(JWTAuth $auth) {
    $this->auth = $auth;
  }

  public function register(Request $r) {
		$type = 0;
		$user = 0;

		/* Kode kelas */
		$uniquePtr = strtoupper(Str::random(6));
		while (Kelas::where('kodeKelas', $uniquePtr)->exists()) {
			$uniquePtr = strtoupper(Str::random(6));
		}

		if (isset($r['namaKelas'])) {
			/* Set account type */
			$type = 'guru';

			/* Create teacher account */
			$user = User::create([
			  'nama'         => $r['nama'],
			  'email'        => $r['email'],
			  'umur'      	 => $r['umur'],
			  'jenisKelamin' => $r['gender'],
			  'jenisAkun'		 => 'guru',
			  'foto'      	 => "null"
			]);

			/* Create class account */
			$kelas = Kelas::create([
			  'namaKelas'  => $r['namaKelas'],
				'jenisKelas' => $r['jenisKelas'],
				'kodeKelas'  => $uniquePtr,
				'guruId'		 => $user['id']
			]);

			/* 
	     * Create social table 
	     * fungsinya utk menaruh token google
	     */
	    $social = TableSosialMedia::create([
	      'uid' => $user['id'],
	      'type' => $type
	    ]);

			return response()->json(['status' => 'success'], 200);
		} else {
			/* Set account type */
			$type = 'murid';

			/* Create student account */
			if (Kelas::where('kodeKelas', '=', $r['kodeKelas'])->count() > 0) {
	      /* Create student data */
	      $user = User::create([
	        'nama' 			   => $r['nama'],
	        'email' 		   => $r['email'],
	        'umur' 			   => $r['umur'],
	        'jenisKelamin' => $r['gender'],
	        'jenisAkun'    => 'murid',
	        'foto'				 => null
	      ]);

	      $kelas = Kelas::where('kodeKelas', '=', $r['kodeKelas'])->first();

	      $relasi = RelasiKelas::create([
	        'uid' => $user['id'],
	        'kid' => $kelas['id'] 
	      ]);

	      /* 
	       * Create social table 
	       * fungsinya utk menaruh token google
	       */
	      $social = TableSosialMedia::create([
	        'uid' => $user['id'],
	        'type' => $type
	      ]);

				return response()->json(['status' => 'success'], 200);
	    }
		}
  }


  public function upload_photo(Request $r) {
  	/* Photo */
		$pathToFile = $r->file('image')->store('images', 'public');

		User::where('nama', $r['nama'])
	      ->where('email', $r['email'])
	      ->update(['foto' => $pathToFile]);

	  return $pathToFile;
  }

  public function login(Request $r) {
    /* Attempt Login with Token */
    if ($r->input('token')) {
      $this->auth->setToken($r->input('token'));

      $user = $this->auth->authenticate();
      if ($user) {
        return response()->json([
          'success' => true,
          'data' => $r->user(),
          'token' => $r->input('token')
        ], 200);
      }
    }

    try {
      if (!$token = $this->auth->attempt($r->only('email'))) {
        return response()->json([
          'success' => false,
          'errors' => [
            'email' => [
              "Invalid email address or password"
            ]
          ]
        ], 422);
      }
    } catch (JWTException $e) {
      return response()->json([
        'success' => false,
        'errors' => [
          'email' => [
            "Invalid email address"
          ]
        ]
      ], 422);
    }

    return response()->json([
      'success' => true,
      'data' => $request->user(),
      'token' => $token
    ], 200);
  }

  /* ME */
  public function index(Request $request) {
    return response()->json([
      'success' => true,
      'data' => $request->user()
    ]);
  }

  public function logout() {
    $this->auth->invalidate();

    return response()->json([
      'success' => true
    ]);
  }

  /* GURU */
  public function murid_by_class(Request $r) {
		/* Check if 'id' exist */
		$kelas = Kelas::where('guruId', $r['guruId'])->first();
		$id = $kelas['id'];

		$students = DB::table('users')
									->select('users.nama', 'users.jenisKelamin', 'users.id')
					  		  ->join('relasi_kelas', 'users.id', '=', 'relasi_kelas.uid')
					  		  ->where('relasi_kelas.kid', '=', $id)
					  		  ->get();

		return response()->json($students, 200);
	}
}
