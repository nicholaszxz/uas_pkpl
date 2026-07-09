<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade as PDF;

use App\Models\Transaksi;
use App\Models\CetakLaporan;
use App\Models\DetailPiutang;
use App\Models\DetailTransaksi;
use App\Models\JenisBarang;
use App\Models\SatuanBarang;
use App\Models\Member;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function laporan($kodeMember)
    {
        $data = [
            'title' => 'Laporan Transaksi',
            'date' => date('m/d/Y'),
            'member' => \App\Models\Member::where(['kode_member' => $kodeMember])->first(),
            'transaksi' => Transaksi::with(['kasir', 'detail', 'piutang'])->where(['member_id' => $kodeMember])->get(),
            'num' => 1
        ];

        $pdf = PDF::loadView('admin.transaksi.testlaporan', $data)->setPaper('a4', 'landscape');

        return $pdf->stream('transaksi_laporan' . date('d-m-y_h-i-s') . '.pdf');
    }

    public function stok()
    {
        $data = [
            'title' => 'Welcome to Tutsmake.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('admin.stok.testlaporan', $data);

        return $pdf->stream('stok_laporan.pdf');
    }

    public function pembelian($noResi)
    {
        $transaksi = Transaksi::with(['kasir', 'member', 'detail'])->where(['jenis_transaksi' => 'pembelian', 'no_resi' => $noResi])->first();

        $data = [
            'transaksi' => $transaksi,
            'total' => 0
        ];

        $pdf = PDF::loadView('admin.transaksi.pdfpembelian', $data);

        return $pdf->stream('laporan-pembelian' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function lpj_harian(Request $request)
    {
        $kelompok = $request->input('kelompok', 'unit');
        $kelompok = $kelompok == '' ? 'unit' : $kelompok;
        $tanggal = $request->input('tanggal', strtotime(now()));
        $tanggal =  $tanggal == '' ? strtotime(now()) : $tanggal;
        $jenis = $request->input('jenis', 'tunai');
        $jenis = $jenis == '' ? 'tunai' : $jenis;
        // return response()->json([
        //     'tanggal' => date('l, d M Y', $tanggal),
        //     'kelompok' => $kelompok,
        //     'jenis' => $jenis
        // ]);

        if ($jenis == 'tunai') {
            if ($kelompok == 'unit') {
                $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
                    ->whereDate('tanggal', '=', date('Y-m-d', $tanggal))
                    ->whereNull('jenis_mmt')
                    ->where(function ($query) {
                        $query->where('jenis_transaksi', 'penjualan')
                            ->orWhere('jenis_transaksi', 'pengiriman');
                    })->get();
            } else {
                $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
                    ->whereDate('tanggal', '=', date('Y-m-d', $tanggal))
                    ->where('jenis_mmt', '=', $kelompok == 'unit' ? '' : $kelompok)
                    ->where(function ($query) {
                        $query->where('jenis_transaksi', 'penjualan')
                            ->orWhere('jenis_transaksi', 'pengiriman');
                    })->get();
            }
        } elseif ($jenis == 'piutang') {
            $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
                ->where(function ($query) use ($kelompok) {
                    if ($kelompok == 'unit') {
                        $query->whereNull('jenis_mmt');
                    } else {
                        $query->where('jenis_mmt', '=', $kelompok);
                    }
                })
                ->where(function ($query) use ($tanggal) {
                    $query->where(function ($isLunas) use ($tanggal) {
                        $isLunas->where('is_lunas', '=', '0')
                            ->whereDate('tanggal', '=', date('Y-m-d', $tanggal));
                    })
                        ->orWhereDate('tanggal_lunas', '=', date('Y-m-d', $tanggal));
                })
                ->where(function ($query) {
                    $query->where('jenis_transaksi', 'penjualan')
                        ->orWhere('jenis_transaksi', 'pengiriman');
                })->get();
        }

        // return response()->json([
        //     'data' => $data
        // ]);

        $viewUrl = $jenis == 'tunai' ? 'admin.transaksi.laporanharian' : 'admin.transaksi.laporanpiutang';

        $pdf = PDF::loadView($viewUrl, [
            'data' => $data,
            'number' => CetakLaporan::generateNumber(['lpj_harian', date('Y-m-d', $tanggal)]),
            'kelompok' => $kelompok,
            'tanggal' => $tanggal,
            'jenis' => $jenis
        ])->setPaper('a4', 'landscape');

        $cetak = new CetakLaporan;
        $cetak->id_kasir = Auth::user()->id;
        $cetak->tanggal = now();
        $cetak->jenis_laporan = 'lpj_harian';
        $cetak->no_cetak = CetakLaporan::generateNumber(['lpj_harian', date('Y-m-d', $tanggal)]);
        $cetak->save();

        return $pdf->stream('lpj_harian_' . "_{$jenis}_" . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function lpb_harian(Request $request)
    {
        $tanggal = $request->input('tanggal', strtotime(now()));
        $tanggal =  $tanggal == '' ? strtotime(now()) : $tanggal;

        // $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->where(['jenis_transaksi' => 'pembelian'])->get();
        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
            ->whereDate('tanggal', '=', date('Y-m-d', $tanggal))
            ->whereNull('jenis_mmt')
            ->where(['jenis_transaksi' => 'pembelian'])->get();

        // return response()->json([$data]);

        $pdf = PDF::loadView('admin.transaksi.laporanharianpembelian', [
            'data' => $data,
            'number' => CetakLaporan::generateNumber(['lpb_harian', date('Y-m-d')]),
            'tanggal' => $tanggal
        ])->setPaper('a4', 'landscape');

        $cetak = new CetakLaporan;
        $cetak->id_kasir = Auth::user()->id;
        $cetak->tanggal = now();
        $cetak->jenis_laporan = 'lpb_harian';
        $cetak->no_cetak = CetakLaporan::generateNumber(['lpb_harian', date('d-m-Y')]);
        $cetak->save();

        return $pdf->stream('lpb_harian_' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function lp_piutang()
    {
        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->where(['jenis_transaksi' => 'penjualan'])->orWhere(['jenis_transaksi' => 'pengiriman'])->whereMonth('created_at', date('m'))->get();

        $pdf = PDF::loadView('admin.transaksi.laporanpiutang', [
            'data' => $data,
            'number' => CetakLaporan::generateNumber(['lp_piutang', date('m')])
        ])->setPaper('a4', 'landscape');

        $cetak = new CetakLaporan;
        $cetak->id_kasir = Auth::user()->id;
        $cetak->tanggal = now();
        $cetak->jenis_laporan = 'lp_piutang';
        $cetak->no_cetak = CetakLaporan::generateNumber(['lp_piutang', date('d-m-Y')]);
        $cetak->save();

        return $pdf->stream('lp_piutang_' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function lp_hutang(Request $request)
    {
        $tanggal = $request->input('tanggal', strtotime(now()));
        $tanggal =  $tanggal == '' ? strtotime(now()) : $tanggal;

        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
            ->where(['jenis_transaksi' => 'pembelian'])
            ->where(function ($query) use ($tanggal) {
                $query->where(function ($isLunas) use ($tanggal) {
                    $isLunas->where('is_lunas', '=', '0')
                        ->whereDate('tanggal', '=', date('Y-m-d', $tanggal));
                })
                    ->orWhereDate('tanggal_lunas', '=', date('Y-m-d', $tanggal));
            })
            ->get();

        $pdf = PDF::loadView('admin.transaksi.laporanhutang', [
            'data' => $data,
            'number' => CetakLaporan::generateNumber(['lp_hutang', date('m')]),
            'tanggal' => $tanggal
        ])->setPaper('a4', 'landscape');

        $cetak = new CetakLaporan;
        $cetak->id_kasir = Auth::user()->id;
        $cetak->tanggal = now();
        $cetak->jenis_laporan = 'lp_hutang';
        $cetak->no_cetak = CetakLaporan::generateNumber(['lp_hutang', date('d-m-Y')]);
        $cetak->save();

        return $pdf->stream('lp_harian_hutang_' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function s_jalan($resi = null)
    {
        $resi = null ? 'WY-190321001' : $resi;
        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->where(['no_resi' => $resi])->first();

        $pdf = PDF::loadView('admin.transaksi.suratjalan', [
            'data' => $data
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('wy_spb_' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function son()
    {
        $jenis = JenisBarang::with(['barang'])->get();
        $transaksi = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->whereMonth('tanggal', date('m'))->get();
        $sold = Transaksi::with(['detail'])->whereMonth('tanggal', '=', date('m'))->get();

        $pdf = PDF::loadView('admin.barang.stockopname', [
            'jenis' => $jenis,
            'transaksi' => $transaksi,
            'sold' => $sold,
            'satuan' => SatuanBarang::all(),
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('son_' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function m_piutang()
    {
        $transaksi = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->where('jenis_transaksi', 'penjualan')->orWhere('jenis_transaksi', 'pengiriman')->get();

        $pdf = PDF::loadView('admin.transaksi.mpiutang', [
            'transaksi' => $transaksi,
            'member' => Member::all(),
            'unit' => Member::select('unit')->where('unit', '!=', 0)->distinct('unit')->get(),
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('mpiutang_' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function m_hutang()
    {
        $transaksi = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->where('jenis_transaksi', 'pembelian')->get();

        $pdf = PDF::loadView('admin.transaksi.mhutang', [
            'transaksi' => $transaksi,
            'member' => Member::all(),
            'unit' => Member::select('unit')->where('unit', 0)->distinct('unit')->get(),
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('mhutang_' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function bk_penjualan()
    {
        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
            ->where(function ($query) {
                $query->where('jenis_transaksi', 'penjualan')
                    ->orWhere('jenis_transaksi', 'pengiriman');
            })
            ->where(function ($queryTanggal) {
                $queryTanggal->where(function ($query) {
                    $query->whereMonth('tanggal', '=', date('m', strtotime(now())))
                        ->whereYear('tanggal', '=', date('Y', strtotime(now())));
                })
                    ->orWhere(function ($query) {
                        $query->whereMonth('tanggal_lunas', '=', date('m', strtotime(now())))
                            ->whereYear('tanggal_lunas', '=', date('Y', strtotime(now())));
                    });
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        // return response()->json([
        //     'akhir_bulan' => date('t'),
        //     'data' => $data
        // ]);

        $pdf = PDF::loadView('admin.transaksi.bukupenjualan', [
            'akhir_bulan' => date('t'),
            'bulan' => date('my'),
            'data' => $data
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('buku_penjualan_' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function bk_pembelian()
    {
        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
            ->where('jenis_transaksi', 'pembelian')
            ->where(function ($queryTanggal) {
                $queryTanggal->where(function ($query) {
                    $query->whereMonth('tanggal', '=', date('m', strtotime(now())))
                        ->whereYear('tanggal', '=', date('Y', strtotime(now())));
                })
                    ->orWhere(function ($query) {
                        $query->whereMonth('tanggal_lunas', '=', date('m', strtotime(now())))
                            ->whereYear('tanggal_lunas', '=', date('Y', strtotime(now())));
                    });
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        // return response()->json([
        //     'akhir_bulan' => date('t'),
        //     'data' => $data
        // ]);

        $pdf = PDF::loadView('admin.transaksi.bukupembelian', [
            'akhir_bulan' => date('t'),
            'bulan' => date('my'),
            'data' => $data
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('buku_pembelian_' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function contoh()
    {
        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
            ->where(function ($query) {
                $query->where('jenis_transaksi', 'penjualan')
                    ->orWhere('jenis_transaksi', 'pengiriman');
            })
            ->where(function ($queryTanggal) {
                $queryTanggal->where(function ($query) {
                    $query->whereMonth('tanggal', '=', date('m', strtotime(now())))
                        ->whereYear('tanggal', '=', date('Y', strtotime(now())));
                })
                    ->orWhere(function ($query) {
                        $query->whereMonth('tanggal_lunas', '=', date('m', strtotime(now())))
                            ->whereYear('tanggal_lunas', '=', date('Y', strtotime(now())));
                    });
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        // return response()->json([
        //     'akhir_bulan' => date('t'),
        //     'data' => $data
        // ]);

        $pdf = PDF::loadView('admin.transaksi.bukupenjualancontoh', [
            'akhir_bulan' => date('t'),
            'bulan' => date('my'),
            'data' => $data
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('buku_penjualan_' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function bln_piutang(Request $request)
    {
        $kelompok = $request->input('kelompok', 'unit');
        $kelompok = $kelompok == '' ? 'unit' : $kelompok;

        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
            ->where(function ($query) {
                $query->where('jenis_transaksi', 'penjualan')
                    ->orWhere('jenis_transaksi', 'pengiriman');
            })
            ->where(function ($query) use ($kelompok) {
                if ($kelompok == 'unit') {
                    $query->whereNull('jenis_mmt');
                } else {
                    $query->where('jenis_mmt', '=', $kelompok);
                }
            })
            ->where(function ($queryTanggal) {
                $queryTanggal->where(function ($query) {
                    $query->where('is_lunas', '=', '0')
                        ->whereMonth('tanggal', '=', date('m', strtotime(now())))
                        ->whereYear('tanggal', '=', date('Y', strtotime(now())));
                })->orWhere(function ($query) {
                    $query->whereMonth('tanggal_lunas', '=', date('m', strtotime(now())))
                        ->whereYear('tanggal_lunas', '=', date('Y', strtotime(now())));
                });
            })
            ->orderBy('tanggal', 'asc')->get();

        $a = 0;
        while ($a < count($data)) {
            $a += 1;
        }

        // return response()->json([$a]);

        $pdf = PDF::loadView('admin.transaksi.laporanbulananpiutang', [
            'akhir_bulan' => date('t'),
            'bulan' => date('m'),
            'data' => $data,
            'kelompok' => $kelompok
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan_bulanan_piutang' . date('d-m-Y_h-i-s') . '.pdf');
    }

    public function bln_hutang(Request $request)
    {
        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
            ->where('jenis_transaksi', '=', 'pembelian')
            ->whereNull('jenis_mmt')
            ->where(function ($queryTanggal) {
                $queryTanggal->where(function ($query) {
                    $query->where('is_lunas', '=', '0')
                        ->whereMonth('tanggal', '=', date('m', strtotime(now())))
                        ->whereYear('tanggal', '=', date('Y', strtotime(now())));
                })->orWhere(function ($query) {
                    $query->whereMonth('tanggal_lunas', '=', date('m', strtotime(now())))
                        ->whereYear('tanggal_lunas', '=', date('Y', strtotime(now())));
                });
            })
            ->orderBy('tanggal', 'asc')->get();

        $a = 0;
        while ($a < count($data)) {
            $a += 1;
        }

        // return response()->json([$a]);

        $pdf = PDF::loadView('admin.transaksi.laporanbulananhutang', [
            'akhir_bulan' => date('t'),
            'bulan' => date('m'),
            'data' => $data,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan_bulanan_hiutang' . date('d-m-Y_h-i-s') . '.pdf');
    }
}
