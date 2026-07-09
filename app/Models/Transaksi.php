<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaksi';
    protected $primaryKey = 'no_resi';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_dpb',
        'tanggal',
        'jenis_transaksi',
        'kasir_id',
        'member_id',
        'total',
        'diskon',
        'uang',
        'donasi',
        'is_lunas',
        'tanggal_lunas',
        'is_print'
    ];

    public function getTanggalsAttribute($val)
    {
        $day = date('l', strtotime($val));
        $month = date('m', strtotime($val));
        $hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jum\'at',
            'Saturday' => 'Sabtu'
        ];
        $tanggal = date('d', strtotime($val));
        $bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        $tahun = date('Y', strtotime($val));
        return $hari[$day] . ', ' . $tanggal . ' ' . $bulan[(int)$month] . ' ' . $tahun;
    }

    public static function incrementId()
    {
        $date = date('dmy');
        $lastId = Self::withTrashed()->where('no_resi', 'like', '%WY-' . $date . '%')->orderBy('no_resi', 'desc')->first();
        if ($lastId) {
            $lastId = $lastId->no_resi;
            $lastId = preg_replace('/WY-/', '', $lastId);
            if (preg_match('/^' . $date . '/', $lastId)) {
                $val = (int)preg_replace('/^' . $date . '/', '', $lastId) + 1;
                $val =  str_pad($val, 3, "0", STR_PAD_LEFT);
                return 'WY-' . $date . $val;
            } else {
                return 'WY-' . $date . '001';
            }
        } else {
            return 'WY-' . $date . '001';
        }
    }

    public static function generateDpb()
    {
        $date = date('dmy');
        $lastId = Self::withTrashed()->where('no_dpb', 'like', '%' . $date . '%')->orderBy('no_dpb', 'desc')->first();
        if ($lastId) {
            $lastId = $lastId->no_dpb;
            if (preg_match('/^' . $date . '/', $lastId)) {
                $val = (int)preg_replace('/^' . $date . '/', '', $lastId) + 1;
                $val =  str_pad($val, 3, "0", STR_PAD_LEFT);
                return $date . $val;
            } else {
                return $date . '001';
            }
        } else {
            return $date . '001';
        }
    }

    public function kasir()
    {
        return $this->hasOne(User::class, 'id', 'kasir_id');
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'kode_member', 'member_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'no_resi');
    }

    public function piutang()
    {
        return $this->hasMany(DetailPiutang::class, 'transaksi_id', 'no_resi');
    }
}
