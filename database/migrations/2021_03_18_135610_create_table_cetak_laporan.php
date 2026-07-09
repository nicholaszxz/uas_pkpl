<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCetakLaporan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cetak_laporan', function (Blueprint $table) {
            $table->id();
            $table->string('no_resi')->nullable();
            $table->string('id_member')->nullable();
            $table->string('id_kasir')->nullable();
            $table->timestamp('tanggal');
            $table->string('jenis_laporan');
            $table->integer('no_cetak');
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
        Schema::dropIfExists('table_cetak_laporan');
    }
}
