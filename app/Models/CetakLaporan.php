<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CetakLaporan extends Model
{
    use HasFactory;

    protected $table = 'cetak_laporan';
    protected $fillable = [
        'no_resi',
        'id_member',
        'id_kasir',
        'tanggal',
        'jenis_laporan',
        'no_cetak'
    ];
    public $timestamps = true;

    public static function generateNumber($data = [])
    {
        /*
         -1 -> jenis laporan
         -2 -> tanggal
         -3 -> cakupan_tanggal ['tanggal', 'bulan', 'tahun']
         -4 -> no_resi (optional)
         -5 -> kasir (optional)
         -6 -> member (optional)
        */

        // $datas = [
        //     'jenis_laporan' => $data[0] or $data['jenis_laporan'],
        //     'tanggal' => '',
        //     'cakupan' => '',
        //     'no_resi' => '',
        //     'kasir' => '',
        //     'member' => ''
        // ];

        // $number = SELF::where(['jenis_laporan' => $data[0]])
        //     ->where(function ($query) use ($data) {
        //         if ($data[2] == 'tanggal') {
        //             $query->whereDate('tanggal', '=', $data[1]);
        //         } elseif ($data[2] == 'bulan') {
        //             $query->whereMonth('tanggal', '=', $data[1]);
        //         } elseif ($data[2] == 'tahun') {
        //             $query->whereYear('tanggal', '=', $data[1]);
        //         }
        //     })->count();

        if ($data[0] == 'lpj_harian') {
            $number = SELF::where(['jenis_laporan' => 'lpj_harian'])->whereDate('tanggal', '=', $data[1])->count();
            return $number == 0 ? 1 : $number + 1;
        } else if ($data[0] == 'lpb_harian') {
            $number = SELF::where(['jenis_laporan' => 'lpb_harian'])->whereDate('tanggal', '=', $data[1])->count();
            return $number == 0 ? 1 : $number + 1;
        } else if ($data[0] == 'lp_piutang') {
            $number = SELF::where(['jenis_laporan' => 'lp_piutang'])->whereMonth('tanggal', '=', $data[1])->count();
            return $number == 0 ? 1 : $number + 1;
        } else if ($data[0] == 'lp_hutang') {
            $number = SELF::where(['jenis_laporan' => 'lp_hutang'])->whereMonth('tanggal', '=', $data[1])->count();
            return $number == 0 ? 1 : $number + 1;
        }
    }
}
