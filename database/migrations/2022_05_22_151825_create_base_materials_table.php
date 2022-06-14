<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('normalisasi');
            $table->string('nama');
            $table->string('deskripsi')->nullable();
            $table->string('satuan');
            $table->float('harga', 20, 5);
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
        Schema::dropIfExists('base_materials');
    }
}
