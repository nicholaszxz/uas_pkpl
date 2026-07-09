<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_transaksi';
    protected $fillable = [
        'transaksi_id',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
        'harga'
    ];

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'transaksi_id', 'no_resi');
    }
}
