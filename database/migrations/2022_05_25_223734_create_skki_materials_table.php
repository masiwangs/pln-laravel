<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkkiMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skki_materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('normalisasi');
            $table->string('nama');
            $table->string('deskripsi');
            $table->string('satuan');
            $table->bigInteger('harga');
            $table->integer('jumlah');
            $table->string('skki_id');
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
        Schema::dropIfExists('skki_materials');
    }
}
