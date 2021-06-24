<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasMuridTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
     */
  public function up() {
    Schema::create('tugas_murid', function (Blueprint $table) {
      $table->id();
      $table->integer('tugasId');
      $table->integer('muridId');
      $table->integer('status');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('tugas_murid');
  }
}
