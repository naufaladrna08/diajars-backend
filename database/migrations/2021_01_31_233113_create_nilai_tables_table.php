<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      Schema::create('nilai_tables', function (Blueprint $table) {
        $table->id();
        $table->integer('uid'); // Student Id
        $table->integer('agama')->default(0);
        $table->integer('motorik_halus')->default(0);
        $table->integer('motorik_kasar')->default(0);
        $table->integer('bahasa')->default(0);
        $table->integer('kognitif')->default(0);
        $table->integer('sosial_emosi')->default(0);
        $table->integer('seni')->default(0);
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_tables');
    }
}
