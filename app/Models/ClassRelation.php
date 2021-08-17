<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRelation extends Model {
  use HasFactory;

  protected $fillable = [
    'person_id', 
    'class_id'
  ];
}
