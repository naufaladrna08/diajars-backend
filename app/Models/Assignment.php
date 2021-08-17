<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model {
  use HasFactory;

  protected $fillable = [
    'id',
    'task_id',
    'person_id',
    'status',
    'score'
  ];
}
