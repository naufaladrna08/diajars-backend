<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('classes', function (Blueprint $table) {
    $table->id();
    $table->integer('teacher_id');
    $table->text("class_name");
    $table->char("class_code");
    $table->char("class_type");
    $table->enum("package_status", ['a', 'b', 'c', 'x'])->default('x');
    $table->timestamps();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down() {
    Schema::dropIfExists('classes');
  }
}
