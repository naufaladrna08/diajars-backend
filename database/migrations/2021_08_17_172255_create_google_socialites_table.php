<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleSocialitesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('google_socialites', function (Blueprint $table) {
      $table->id();
      $table->integer('person_id');
      $table->enum('type', ['teacher', 'student'])->default('teacher');
      $table->string('google_id')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('google_socialites');
  }
}
