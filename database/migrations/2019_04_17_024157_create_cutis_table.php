<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCutisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cutis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pengaju_cuti');
            $table->string('dituju_cuti');
            $table->date('tgl_cuti_mulai');
            $table->date('tgl_cuti_selesai')->nullable();
            $table->string('status');
            $table->string('keterangan_cuti')->nullable();
            $table->string('keterangan_balasan_cuti')->nullable();
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
        Schema::dropIfExists('cutis');
    }
}
