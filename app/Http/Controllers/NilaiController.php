<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RelasiKelas;
use App\Models\TableSosialMedia;
use App\Models\Kelas;
use App\Models\MateriTable;
use App\Models\GameTable;
use App\Models\TugasTable;
use App\Models\NilaiTable;
use Tymon\JWTAuth\JWTAuth;

class NilaiController extends Controller{
	public function __construct(JWTAuth $auth) {
    $this->auth = $auth;
  }

  public function tambah_nilai(Request $r) {
  	$user = auth()->user();;

  	// NilaiTable::where('uid', $userdata['id'])->update([
  	// 	'agama' => $r['nilai']
  	// ]);

  	return response()->json($r->cookie('auth._token.local'), 200);
  }
}
