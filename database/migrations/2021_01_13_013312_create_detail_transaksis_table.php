<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('transaksi_id');
            $table->index('transaksi_id');
            $table->foreign('transaksi_id')->references('no_resi')->on('transaksi')->onDelete('cascade');
            $table->string('kode_barang');
            $table->index('kode_barang');
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('cascade');
            $table->string('nama_barang');
            $table->float(('jumlah'));
            $table->string('satuan');
            $table->integer('harga');
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
        Schema::dropIfExists('detail_transaksi', function (Blueprint $table) {
            $table->dropForeign('detail_transaksi_transaksi_id_foreign');
            $table->dropIndex('detail_transaksi_transaksi_id_index');
            $table->dropColumn('transaksi_id');
            $table->dropForeign('detail_transaksi_kode_barang_foreign');
            $table->dropIndex('detail_transaksi_kode_barang_index');
            $table->dropColumn('kode_barang');
        });
    }
}
