<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasTable extends Model {
  use HasFactory;

  protected $fillable = [
  	'nama',
  	'kelasId',
  	'tipe',
  	'tugasId',
  ];
}
