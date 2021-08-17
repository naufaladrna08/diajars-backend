<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {
  protected $fillable = [
    'name',
    'class_id',
    'type',
    'another_table_id',
  ];
}
