<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas_tables', function (Blueprint $table) {
            $table->id();
            $table->char('nama');
            $table->integer('kelasId');
            $table->integer('tugasId'); // Materi Id atau Game Id
            $table->enum('tipe', ['materi', 'game']);
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
        Schema::dropIfExists('tugas_tables');
    }
}
