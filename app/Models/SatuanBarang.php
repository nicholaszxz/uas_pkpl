<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SatuanBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'satuan_barang';
    protected $fillable = [
        'kode_barang',
        'nama_satuan',
        'stok',
        'harga_beli',
        'harga_jual'
    ];

    public function barang()
    {
        return $this->hasOne(Barang::class, 'kode_barang', 'kode_barang');
    }
}
