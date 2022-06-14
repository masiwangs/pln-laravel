<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaksanaanMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelaksanaan_materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tanggal');
            $table->string('tug9');
            $table->string('normalisasi');
            $table->string('nama');
            $table->string('deskripsi')->nullable();
            $table->string('satuan');
            $table->bigInteger('harga');
            $table->integer('jumlah');
            $table->enum('transaksi', ['masuk', 'keluar'])->default('keluar');
            $table->string('pelaksanaan_id');
            $table->string('base_material_id');
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
        Schema::dropIfExists('pelaksanaan_materials');
    }
}
