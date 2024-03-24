<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Produk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_m', function (Blueprint $table) {
            $table->id();
            $table->boolean('statusenabled');
            $table->string('namaproduk');
            $table->integer('kategori_id');
            $table->integer('stok');
            $table->integer('harga');
            $table->datetime('tgl_kadaluarsa');
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
        Schema::dropIfExists('produk_m');
    }
}
