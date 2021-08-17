<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('scores', function (Blueprint $table) {
      $table->id();
      $table->integer('person_id'); // Student Id
      $table->integer('religion')->default(0);
      $table->integer('motorik_halus')->default(0);
      $table->integer('motorik_kasar')->default(0);
      $table->integer('language')->default(0);
      $table->integer('cognitive')->default(0);
      $table->integer('social_emotion')->default(0);
      $table->integer('art')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('scores');
  }
}
