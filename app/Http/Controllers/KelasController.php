<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\ClassRelation;
use App\Models\GoogleSocialite;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Game;
use App\Models\Task;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller {
  public function check_class_state(Request $r) {
  	$kelas = Classes::where('teacher_id', $r['guruId'])->first();

  	return response()->json($kelas, 200);
  }

  public function student_get_class(Request $r) {
    $relasi_kelas = ClassRelation::where('person_id', $r['muridId'])->first();
    $kelas        = Classes::where('id', $relasi_kelas['kid'])->first();
    
    return response()->json($kelas, 200);
  }

  public function get_materi(Request $r) {
  	$materi = Subject::where('class_type', $r['jenisKelas'])->get();

  	return response()->json($materi, 200);
  }

  public function get_games(Request $r) {
  	$games = Game::where('class_type', $r['jenisKelas'])->get();

  	return response()->json($games, 200);
  }

  public function add_task(Request $r) {
    /* Pertama, dapatkan dulu data-data muridnya. >//< */
    $students = DB::table('users')
                  ->select('users.name', 'users.gender', 'users.id')
                  ->join('class_relations', 'users.id', '=', 'class_relations.person_id')
                  ->where('class_relations.kid', '=', $r['kelasId'])
                  ->get();

    $kelas = Task::create([
      'name'             => $r['nama'],
      'another_table_id' => $r['tugasId'],
      'class_id'         => $r['kelasId'],
      'type'             => $r['type'],
    ]);

    foreach ($students as $student) {
      $tugas = Assignment::create([
        'task_id'   => $kelas['id'],
        'status'    => 0,
        'score'     => 0,
        'person_id' => $student->id
      ]);
    }

    return response()->json(['status' => 'success'], 200);
  }

  public function get_task(Request $r) {
    $task = null;

    if (isset($r['tugasId'])) {
      $task = DB::table('tasks')
                ->select('tasks.*', 'assignments.status', 'assignments.score', 'assignments.task_id', $r['type'] . '.link')
                ->join('assignments', 'assignments._tugasId', '=', 'tasks.id')
                ->join($r['type'], $r['type'] . '.id', '=', 'tasks.tugasId')
                ->where('tasks.another_table_id', '=', $r['tugasId'])
                ->where('tasks.tipe', '=', $r['type'])
                ->where('assignments.person_id', '=', $r['muridId'])
                ->first();

    } else if (isset($r['muridId'])) {
      /* Get tasks for students */
        $task = DB::table('tasks')
                    ->select('tasks.*', 'tugas_murid.status', 'tugas_murid.nilai', 'tugas_murid._tugasId')
                    ->join('tugas_murid', 'tugas_murid._tugasId', '=', 'tasks.id')
                    ->where('tugas_murid.muridId', '=', $r['muridId'])
                    ->get();
      } else {
      /* Get tasks for teacher */
      $kelas = Classes::where('kodeKelas', $r['kodeKelas'])->first();

      $task = Task::where('kelasId', $kelas['id'])->get();
    }

    return response()->json($task, 200);
  }

  public function delete_task(Request $r) {
    /* Dapatkan Record dari Tugas Table */
    $task = Task::where('tugasId', '=', $r['tugasId'])->first();

    /* Hapus Record dari Tugas Murid berdasarkan $task->id */
    $studentTask = Assignment::where('_tugasId', $task->id)->delete();

    /* Hapus Record dari Tugas Table berdasarkan $r['id'] */
    $task = Task::where('tugasId', '=', $r['tugasId'])->delete();

    return response()->json(['status' => 'success'], 200);
  }
}
