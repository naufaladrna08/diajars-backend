<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSosialMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('social_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('uid'); // This can be Student ID or Teacher ID
            $table->enum('type', ['guru', 'murid'])->default('guru');
            $table->string('social_id')->nullable();
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
        Schema::dropIfExists('table_sosial_media');
    }
}
