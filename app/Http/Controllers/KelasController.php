<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\RelasiKelas;
use App\Models\TableSosialMedia;
use App\Models\Kelas;
use App\Models\MateriTable;
use App\Models\GameTable;

class KelasController extends Controller {
  public function check_class_state(Request $r) {
  	$kelas = Kelas::where('guruId', $r['guruId'])->first();

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
}
