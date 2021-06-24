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
use App\Models\TugasMurid;
use App\Models\NilaiTable;
use Tymon\JWTAuth\JWTAuth;

class NilaiController extends Controller{
	public function __construct(JWTAuth $auth) {
    $this->auth = $auth;
  }

  /**
   * Tambahkan nilai pelajaran mengenal angka. 
   */
  public function mengenal_angka(Request $r) {
    $user = TugasMurid::where('muridId', $r['id'])
                      ->where('_tugasId', $r['tugas_id'])
                      ->first();
    
    // if ($user->status == 0) {
      NilaiTable::where('uid', $r['id'])
                ->increment('kognitif' , $r['nilai']);

      TugasMurid::where('muridId', $r['id'])
                ->where('_tugasId', $r['tugas_id'])
                ->update(['status' => 1, 'nilai' => $r['nilai']]);
    // }

    return response()->json($r, 200);
  }

  /**
   * Tambahkan nilai pelajaran mengenal angka. 
   */
  public function mengenal_huruf(Request $r) {
    $user = TugasMurid::where('muridId', $r['id'])
                      ->where('_tugasId', $r['tugas_id'])
                      ->first();

    if ($user->status == 0) {
      NilaiTable::where('uid', $r['id'])
                ->increment('kognitif' , $r['nilai']);

      TugasMurid::where('muridId', $r['id'])
                ->where('_tugasId', $r['tugas_id'])
                ->update(['status' => 1, 'nilai' => $r['nilai']]);
    }

    return response()->json($r, 200);
  }
}
