<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClassRelation;
use App\Models\GoogleSocialite;
use App\Models\Classes;
use App\Models\Score;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\JWTAuth;
use Socialite;
use Concerns\InteractsWithInput;
use Illuminate\Support\Facades\Http;

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
		$uniqueStr = strtoupper(Str::random(6));
		while (Classes::where('class_code', $uniqueStr)->exists()) {
			$uniqueStr = strtoupper(Str::random(6));
		}

		if (isset($r['namaKelas'])) {
			/* Set account type */
			$type   = 'teacher';
			$gender = null;

			if ($r['gender'] == 'Laki-laki') {
				$gender = 'Male';
			} else if ($r['gender'] == 'Perempuan') {
				$gender = 'Female';
			} else {
				$gender = null;
			}

			/* Create teacher account */
			$user = User::create([
			  'name'          => $r['nama'],
			  'email'         => $r['email'],
			  'age'        	  => $r['umur'],
			  'gender' 			  => $gender,
			  'account_type'  => $type,
			  'profile_photo' => 'null'
			]);

			/* Create class account */
			$kelas = Classes::create([
			  'class_name' => $r['namaKelas'],
				'class_type' => $r['jenisKelas'],
				'class_code' => $uniqueStr,
				'teacher_id' => $user['id']
			]);

			/* 
	     * Create social table 
	     * fungsinya utk menaruh token google
	     */
	    $social = GoogleSocialite::create([
	      'person_id' => $user['id'],
	      'type' 			=> $type
	    ]);

			\DB::statement("UPDATE users SET person_id=id WHERE id=$user->id");

			return response()->json(['status' => 'success'], 200);
		} else {
			/* Set account type */
			$type = 'student';
			$gender = null;
			
			if ($r['gender'] == 'Laki-laki') {
				$gender = 'Male';
			} else if ($r['gender'] == 'Perempuan') {
				$gender = 'Female';
			} else {
				$gender = null;
			}

			/* Create student account */
			if (Classes::where('class_code', '=', $r['kodeKelas'])->count() > 0) {
	      /* Create student data */
	      $user = User::create([
	        'name' 			   	=> $r['nama'],
	        'email' 		   	=> $r['email'],
	        'age' 			   	=> $r['umur'],
	        'gender'			  => $gender,
	        'account_type'  => $type,
	        'profile_photo'	=> null
	      ]);

	      $kelas = Classes::where('class_code', '=', $r['kodeKelas'])->first();

	      $relasi = ClassRelation::create([
	        'person_id' => $user['id'],
	        'class_id'  => $kelas['id'] 
	      ]);

	      $nilai = Score::create([
	      	'person_id' => $user['id']
	      ]);

	      /* 
	       * Create social table 
	       * fungsinya utk menaruh token google
	       */
	      $social = GoogleSocialite::create([
	        'person_id' => $user['id'],
	        'type'      => $type
	      ]);

				\DB::statement("UPDATE users SET person_id=id WHERE id=$user->id");

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

	public function get_statistic(Request $r) {
		$stats = NilaiTable::where('uid', $r['muridId'])->first();

		return response()->json($stats, 200);
	}

	/* MURID */
	public function get_murid_by_id(Request $r) {
		$stats = User::where('id', $r['muridId'])->first();

		return response()->json($stats, 200);
	}
}
