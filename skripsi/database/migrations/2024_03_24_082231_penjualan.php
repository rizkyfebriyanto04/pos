<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Penjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_t', function (Blueprint $table) {
            $table->id();
            $table->boolean('statusenabled');
            $table->string('no_penjualan');
            $table->integer('user_id');
            $table->integer('total');
            $table->integer('bayar');
            $table->datetime('tanggal_jual');
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
        Schema::dropIfExists('penjualan_t');
    }
}
