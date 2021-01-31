<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\RelasiKelas;
use App\Models\TableSosialMedia;
use App\Models\Kelas;

class KelasController extends Controller {
  public function check_class_state(Request $r) {
  	$kelas = Kelas::where('guruId', $r['guruId'])->first();

  	return $kelas['statusPaket'];
  }
}
