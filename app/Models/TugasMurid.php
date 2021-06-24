<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasMurid extends Model {
  use HasFactory;

  protected $table = "tugas_murid";
  protected $fillable = [
    'id',
    '_tugasId',
    'muridId',
    'status',
    'nilai'
  ];
}
