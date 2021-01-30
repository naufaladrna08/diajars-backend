<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableSosialMedia extends Model {  
  use HasFactory;

  protected $table = 'social_tables';
  protected $fillable = ['uid', 'type', 'social_id'];
}
