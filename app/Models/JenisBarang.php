<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_barang';
    protected $fillable = [
        'nama_jenis',
    ];
    public $timestamps = true;

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_jenis', 'id');
    }
}
