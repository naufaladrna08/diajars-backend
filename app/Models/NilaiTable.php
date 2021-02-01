<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiTable extends Model {
  use HasFactory;

  protected $fillable = [
  	'uid',
  	'agama',
  	'motorik_halus', 
  	'motorik_kasar', 
  	'bahasa', 
  	'kognitif', 
  	'sosial_emosi', 
  	'seni'
  ];
}
