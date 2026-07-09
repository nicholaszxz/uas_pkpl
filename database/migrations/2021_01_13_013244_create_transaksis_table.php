<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('no_resi')->primary();
            $table->timestamp('tanggal');
            $table->enum('jenis_transaksi', ['pembelian', 'penjualan', 'pengiriman']);
            $table->string('kasir_id');
            $table->index('kasir_id');
            $table->foreign('kasir_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('member_id');
            $table->index('member_id');
            $table->foreign('member_id')->references('kode_member')->on('member')->onDelete('cascade');
            $table->integer('total');
            $table->float('diskon')->nullable();
            $table->double('uang', 12, 2)->nullable();
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
        Schema::dropIfExists('transaksi', function (Blueprint $table) {
            $table->dropForeign('transaksi_kasir_id_foreign');
            $table->dropIndex('transaksi_kasir_id_index');
            $table->dropColumn('kasir_id');
            $table->dropForeign('transaksi_member_id_foreign');
            $table->dropIndex('transaksi_member_id_index');
            $table->dropColumn('member_id');
        });
    }
}
