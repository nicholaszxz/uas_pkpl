<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisBarangInBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jenis')->after('nama')->nullable();
            $table->index('id_jenis');
            $table->foreign('id_jenis')->references('id')->on('jenis_barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropForeign('barang_id_jenis_foreign');
            $table->dropIndex('barang_id_jenis_index');
            $table->dropColumn('id_jenis');
        });
    }
}
