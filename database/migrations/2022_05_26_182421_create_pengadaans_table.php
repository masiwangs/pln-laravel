<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengadaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengadaans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nodin')->nullable();
            $table->date('tgl_nodin')->nullable();
            $table->string('pr')->nullable();
            $table->string('nama')->nullable();
            $table->enum('status', ['PROSES', 'TERKONTRAK'])->nullable();
            $table->integer('basket');
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
        Schema::dropIfExists('pengadaans');
    }
}
