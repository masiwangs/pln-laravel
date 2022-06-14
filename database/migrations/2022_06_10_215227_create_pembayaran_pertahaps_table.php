<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranPertahapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_pertahaps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tanggal');
            $table->bigInteger('nominal');
            $table->longText('keterangan')->nullable();
            $table->string('pembayaran_id');
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
        Schema::dropIfExists('pembayaran_pertahaps');
    }
}
