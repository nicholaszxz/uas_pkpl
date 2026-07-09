<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSatuanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satuan_barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->index('kode_barang');
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('cascade');
            $table->string('nama_satuan');
            $table->float('rasio');
            $table->integer('harga_beli')->nullable();
            $table->integer('harga_jual');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('satuan_barang', function (Blueprint $table) {
            $table->dropForeign('satuan_barang_kode_barang_foreign');
            $table->dropIndex('satuan_barang_kode_barang_index');
            $table->dropColumn('kode_barang');
        });
    }
}
