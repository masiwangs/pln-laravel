<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkkisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skkis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('skki')->nullable();
            $table->string('prk_skki')->nullable();
            $table->string('wbs_jasa')->nullable();
            $table->string('wbs_material')->nullable();
            $table->string('prk_id')->nullable();
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
        Schema::dropIfExists('skkis');
    }
}
