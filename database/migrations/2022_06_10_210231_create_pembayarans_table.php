<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', ['DALAM PELAKSANAAN', 'ADMINISTRASI PROYEK', 'OUTSTANDING', 'SELESAI BAYAR'])->default('DALAM PELAKSANAAN');
            $table->integer('basket')->default(1);
            $table->string('pelaksanaan_id');
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
        Schema::dropIfExists('pembayarans');
    }
}
