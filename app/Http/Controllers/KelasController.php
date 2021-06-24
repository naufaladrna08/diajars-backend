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
use Illuminate\Support\Facades\DB;

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
    /* Pertama, dapatkan dulu data-data muridnya. >//< */
    $students = DB::table('users')
                  ->select('users.nama', 'users.jenisKelamin', 'users.id')
                  ->join('relasi_kelas', 'users.id', '=', 'relasi_kelas.uid')
                  ->where('relasi_kelas.kid', '=', $r['kelasId'])
                  ->get();

    $kelas = TugasTable::create([
      'nama'    => $r['nama'],
      'tugasId' => $r['tugasId'],
      'kelasId' => $r['kelasId'],
      'tipe'    => $r['type'],
    ]);

    foreach ($students as $student) {
      $tugas = TugasMurid::create([
        '_tugasId' => $kelas['id'],
        'status'  => 0,
        'nilai'  => 0,
        'muridId' => $student->id
      ]);
    }

    return response()->json(['status' => 'success'], 200);
  }

  public function get_task(Request $r) {
    $task = null;

    if (isset($r['tugasId'])) {
      /* Get Task Detail */
      // if ($r['type'] == "materi") {
      //   $task = MateriTable::where('id', $r['tugasId'])->first();
      // } else if ($r['type'] == "game") {
      //   $task = GameTable::where('id', $r['tugasId'])->first();
      // } else {
      //   $task = null;
      // }

      $task = DB::table('tugas_tables')
                ->select('tugas_tables.*', 'tugas_murid.status', 'tugas_murid.nilai', 'tugas_murid._tugasId', $r['type'] . '_tables.link')
                ->join('tugas_murid', 'tugas_murid._tugasId', '=', 'tugas_tables.id')
                ->join($r['type'] . '_tables', $r['type'] . '_tables.id', '=', 'tugas_tables.tugasId')
                ->where('tugas_tables.tugasId', '=', $r['tugasId'])
                ->where('tugas_tables.tipe', '=', $r['type'])
                ->where('tugas_murid.muridId', '=', $r['uid'])
                ->first();

    } else if (isset($r['muridId'])) {
      /* Get tasks for students */
        $task = DB::table('tugas_tables')
                    ->select('tugas_tables.*', 'tugas_murid.status', 'tugas_murid.nilai', 'tugas_murid._tugasId')
                    ->join('tugas_murid', 'tugas_murid._tugasId', '=', 'tugas_tables.id')
                    ->where('tugas_murid.muridId', '=', $r['muridId'])
                    ->get();
      } else {
      /* Get tasks for teacher */
      $kelas = Kelas::where('kodeKelas', $r['kodeKelas'])->first();

      $task = TugasTable::where('kelasId', $kelas['id'])->get();
    }

    return response()->json($task, 200);
  }

  public function delete_task(Request $r) {
    /* Dapatkan Record dari Tugas Table */
    $task = TugasTable::where('tugasId', '=', $r['tugasId'])->first();

    /* Hapus Record dari Tugas Murid berdasarkan $task->id */
    $studentTask = TugasMurid::where('_tugasId', $task->id)->delete();

    /* Hapus Record dari Tugas Table berdasarkan $r['id'] */
    $task = TugasTable::where('tugasId', '=', $r['tugasId'])->delete();

    return response()->json(['status' => 'success'], 200);
  }
}
