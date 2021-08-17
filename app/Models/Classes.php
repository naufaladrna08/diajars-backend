<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model {
  use HasFactory;

  protected $fillable = [
    'teacher_id', 
    'class_name', 
    'class_code',	
    'class_type', 
    'package_staus'
  ];
}
