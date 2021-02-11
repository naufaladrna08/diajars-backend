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

class KelasController extends Controller {
  public function check_class_state(Request $r) {
  	$kelas = Kelas::where('guruId', $r['guruId'])->first();

  	return response()->json($kelas, 200);
  }

  public function student_get_class(Request $r) {
    $relasi_kelas = RelasiKelas::where('uid', $r['muridId'])->first();
    $kelas        = Kelas::where('id', $relasi_kelas['kid'])->first();
    
    return response()->json($kelas, 200);
  }

  public function get_materi(Request $r) {
  	$materi = MateriTable::where('jenisKelas', $r['jenisKelas'])->get();

  	return response()->json($materi, 200);
  }

  public function get_games(Request $r) {
  	$games = GameTable::where('jenisKelas', $r['jenisKelas'])->get();

  	return response()->json($games, 200);
  }

  public function add_task(Request $r) {
    $kelas = TugasTable::create([
      'nama'    => $r['nama'],
      'tugasId' => $r['tugasId'],
      'kelasId' => $r['kelasId'],
      'tipe'    => $r['type']
    ]);

    return response()->json(['status' => 'success'], 200);
  }

  public function get_task(Request $r) {
    $task = null;

    if (isset($r['tugasId'])) {
      /* Get Task Detail */
    } else {
      /* Get tasks */
      $kelas = Kelas::where('kodeKelas', $r['kodeKelas'])->first();

      $task = TugasTable::where('kelasId', $kelas['id'])->get();
    }

    return response()->json($task, 200);
  }
}
