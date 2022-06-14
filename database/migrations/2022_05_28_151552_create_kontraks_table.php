<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontraksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontraks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_kontrak')->nullable();
            $table->date('tgl_kontrak')->nullable();
            $table->date('tgl_awal')->nullable();
            $table->date('tgl_akhir')->nullable();
            $table->string('pelaksana')->nullable();
            $table->string('direksi')->nullable();
            $table->string('pengadaan_id');
            $table->boolean('is_amandemen')->default(false);
            $table->string('versi_amandemen')->nullable();
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
        Schema::dropIfExists('kontraks');
    }
}
