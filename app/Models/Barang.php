<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang';
    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kode_barang',
        'nama',
        'stok',
        'id_jenis'
    ];
    public $timestamps = true;

    public static function incrementId()
    {
        $date = date('ymd');
        $lastId = Self::withTrashed()->where('kode_barang', 'like', '%B-' . $date . '%')->orderBy('kode_barang', 'desc')->first();
        if ($lastId) {
            $lastId = $lastId->kode_barang;
            $lastId = preg_replace('/B-/', '', $lastId);
            if (preg_match('/^' . $date . '/', $lastId)) {
                $val = (int)preg_replace('/^' . $date . '/', '', $lastId) + 1;
                $val =  str_pad($val, 3, "0", STR_PAD_LEFT);
                return 'B-' . $date . $val;
            } else {
                return 'B-' . $date . '001';
            }
        } else {
            return 'B-' . $date . '001';
        }
    }

    public function satuan()
    {
        return $this->hasMany(SatuanBarang::class, 'kode_barang', 'kode_barang');
    }

    public function jenis()
    {
        return $this->hasOne(JenisBarang::class, 'id', 'id_jenis');
    }
}
