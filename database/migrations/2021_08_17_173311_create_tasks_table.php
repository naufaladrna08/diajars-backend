<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->char('name');
      $table->integer('class_id');
      $table->integer('another_table_id'); // Materi Id atau Game Id
      $table->integer('status'); // 0 Belum dikerjakan, 1 sudah
      $table->enum('type', ['subject', 'game']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('tasks');
  }
}
