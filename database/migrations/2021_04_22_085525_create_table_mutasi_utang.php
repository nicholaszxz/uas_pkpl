<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMutasiUtang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutasi_utang', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal');
            $table->string('kode_member');
            $table->index('kode_member');
            $table->foreign('kode_member')->references('kode_member')->on('member')->onDelete('cascade');
            $table->enum('jenis_utang', ['piutang', 'hutang']);
            $table->double('saldo_awal', 12, 8);
            $table->double('penambahan', 12, 8);
            $table->double('pembayaran', 12, 8);
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
        Schema::dropIfExists('mutasi_utang', function (Blueprint $table) {
            $table->dropForeign('mutasi_utang_kode_member_foreign');
            $table->dropIndex('mutasi_utang_kode_member_index');
            $table->dropColumn('kode_member');
        });
    }
}
