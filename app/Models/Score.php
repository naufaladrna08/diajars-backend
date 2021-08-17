<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model {
  use HasFactory;

  protected $fillable = [
  	'person_id',
  	'religion',
  	'motorik_halus', 
  	'motorik_kasar', 
  	'language', 
  	'cognitve', 
  	'social_emotion', 
  	'art'
  ];
}
