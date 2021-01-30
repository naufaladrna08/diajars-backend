<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelasiKelas extends Model {
  use HasFactory;

  protected $fillable = ['uid', 'kid'];
}
