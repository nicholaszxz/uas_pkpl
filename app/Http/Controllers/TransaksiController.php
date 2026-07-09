<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\DetailPiutang;
use App\Models\Member;
use App\Models\Barang;
use App\Models\SatuanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noResi = Transaksi::incrementId();
        $barang = Barang::with('satuan')->get();
        $member = Member::where('jenis_member', 'customer')->where('unit', '!=', 0)->get();
        $sideTitle = "transaksi";
        return view('admin.transaksi.transaksi', [
            'noResi' => $noResi,
            'barang' => $barang,
            'member' => $member,
            'sideTitle' => $sideTitle
        ]);
    }

    public function __pembelian()
    {
        $noResi = Transaksi::incrementId();
        $barang = Barang::with('satuan')->get();
        $member = Member::where('jenis_member', 'supplier')->where('nama', 'not like', '%general-%')->get();
        $sideTitle = "pembelian";
        return view('admin.transaksi.pembelian', [
            'noResi' => $noResi,
            'barang' => $barang,
            'member' => $member,
            'sideTitle' => $sideTitle
        ]);
    }

    public function showBarang($barcode)
    {
        $barang = Barang::with('satuan')
            ->where('barcode', $barcode)
            ->orWhere('kode_barang', $barcode)
            ->get();
        if ($barang->count() > 0) {
            return response()->json([
                'message' => 'success',
                'barang' => $barang
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed'
            ], 500);
        }
    }

    public function getBarang()
    {
        return response()->json([
            'barang' => Barang::with('satuan')->get()
        ]);
    }

    public function getMember()
    {
        return response()->json([
            'member' => Member::where('jenis_member', 'customer')->where('nama', 'not like', '%general-%')->get()
        ]);
    }

    public function getSupplier()
    {
        return response()->json([
            'member' => Member::where('jenis_member', 'supplier')->where('nama', 'not like', '%general-%')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->jenis_transaksi == 'penjualan' || $request->jenis_transaksi == 'pengiriman') { // penjualan
            $data = $request->all();
            $loopData = count(collect($request)->get('detail_transaksi'));
            $noResi = Transaksi::incrementId();
            $idKasir = Auth::user()->id;
            $tanggal = now();

            // Member
            if ($request->kode_member == "") {
                $member = true;
                $memberId = 'U-00-01';
            } else {
                $member = true;
                $memberId = $request->kode_member;
            }
            // End

            // Transaksi
            $transaksi = new Transaksi;
            $transaksi->no_resi = $noResi;
            $transaksi->tanggal = $request->tanggal == '' ? $tanggal : $request->tanggal;
            $transaksi->jenis_transaksi = $request->jenis_transaksi;
            $transaksi->jenis_mmt = $request->jenis_mmt;
            $transaksi->kasir_id = $idKasir;
            $transaksi->member_id = $memberId;
            $transaksi->total = $request->total;
            $transaksi->diskon = $request->diskon;
            $transaksi->uang = $request->uang;
            $transaksi->donasi = $request->donasi;
            $transaksi->is_lunas = $request->is_lunas;
            $transaksi->is_print = $request->is_print;
            // End


            if ($data && $transaksi && $member) {

                $transaksi->save();

                // Detail Transaksi
                for ($i = 0; $i < $loopData; $i++) {
                    $detail = new DetailTransaksi;
                    $detail->transaksi_id = $noResi;
                    $detail->kode_barang = $request->detail_transaksi[$i]['kode'];
                    $detail->nama_barang = $request->detail_transaksi[$i]['nama'];
                    $detail->jumlah = $request->detail_transaksi[$i]['jumlah'];
                    $detail->satuan = $request->detail_transaksi[$i]['satuan'];
                    $detail->harga = $request->detail_transaksi[$i]['harga'];
                    $detail->save();

                    // edit stok barang
                    $barang = new Barang;
                    $stok = $barang->where('kode_barang', $request->detail_transaksi[$i]['kode'])->first()->stok;
                    $barang->where('kode_barang', $request->detail_transaksi[$i]['kode'])
                        ->update([
                            'stok' => floatval(floatval($stok) - floatval($request->detail_transaksi[$i]['jumlah']))
                        ]);
                }
                // End

                // piutang
                if ($request->is_lunas == '0' && (int)$request->uang > 0) {
                    $piutang = new DetailPiutang;
                    $piutang->transaksi_id = $noResi;
                    $piutang->tanggal = $tanggal;
                    $piutang->kasir_id = $idKasir;
                    $piutang->uang = $request->uang;
                    $piutang->save();
                }
                // end

                return response()->json([
                    'message' => 'success',
                    'data' => $data,
                    'no_resi' => $noResi,
                    'id_kasir' => $idKasir
                ], 200);
            } else {
                return response()->json([
                    'message' => 'failed'
                ], 500);
            }
        } else if ($request->jenis_transaksi == 'pembelian') { // pembelian
            $noResi = Transaksi::incrementId();
            $idKasir = Auth::user()->id;
            $memberId = $request->kode_supplier == '' ? 'U-00-02' : $request->kode_supplier;
            $loopData = count(collect($request)->get('detail_transaksi'));
            $noDpb = $request->no_dpb == '' ? Transaksi::generateDpb() : $request->no_dpb;

            // member
            // end

            // Transaksi
            $transaksi = new Transaksi;
            $transaksi->no_resi = $noResi;
            $transaksi->no_dpb = $noDpb;
            $transaksi->tanggal = $request->tanggal == '' ? now() : date_format(date_create($request->tanggal), 'Y-m-d H:i:s');
            $transaksi->jenis_transaksi = $request->jenis_transaksi;
            $transaksi->kasir_id = $idKasir;
            $transaksi->member_id = $memberId;
            $transaksi->total = $request->total;
            $transaksi->diskon = null;
            $transaksi->is_lunas = $request->is_lunas;
            $transaksi->save();
            // End

            // Detail Transaksi
            for ($i = 0; $i < $loopData; $i++) {
                $detail = new DetailTransaksi;
                $detail->transaksi_id = $noResi;

                // edit stok barang
                if ($request->detail_transaksi[$i]['baru'] == 'false') {
                    $detail->kode_barang = $request->detail_transaksi[$i]['kode'];

                    $barang = new Barang;
                    $stok = $barang->where('kode_barang', $request->detail_transaksi[$i]['kode'])->first()->stok;
                    $barang->where('kode_barang', $request->detail_transaksi[$i]['kode'])
                        ->update([
                            'stok' => floatval(floatval($stok) + floatval($request->detail_transaksi[$i]['jumlah'])),
                        ]);
                    $satuan = new SatuanBarang;
                    $satuan->where([
                        'kode_barang' => $request->detail_transaksi[$i]['kode'],
                        'nama_satuan' => $request->detail_transaksi[$i]['satuan']
                    ])
                        ->update([
                            'harga_beli' => $request->detail_transaksi[$i]['harga'],
                        ]);
                } else {
                    $kodeBarang = Barang::incrementId();
                    $detail->kode_barang = $kodeBarang;

                    $barang = new Barang;
                    $barang->kode_barang = $kodeBarang;
                    $barang->barcode = $request->detail_transaksi[$i]['barcode'];
                    $barang->nama = $request->detail_transaksi[$i]['nama'];
                    $barang->stok = $request->detail_transaksi[$i]['jumlah'];
                    $barang->save();
                    $satuan = new SatuanBarang;
                    $satuan->kode_barang = $kodeBarang;
                    $satuan->nama_satuan = $request->detail_transaksi[$i]['satuan'];
                    $satuan->rasio = 1;
                    $satuan->harga_beli = $request->detail_transaksi[$i]['harga'];
                    $satuan->harga_jual = $request->detail_transaksi[$i]['harga'];
                    $satuan->harga_supl = $request->detail_transaksi[$i]['harga'];
                    $satuan->save();
                }
                // end

                $detail->nama_barang = $request->detail_transaksi[$i]['nama'];
                $detail->jumlah = $request->detail_transaksi[$i]['jumlah'];
                $detail->satuan = $request->detail_transaksi[$i]['satuan'];
                $detail->harga = $request->detail_transaksi[$i]['total'];
                $detail->save();
            }
            // End

            if ($transaksi && $detail && $barang) {
                return response()->json([
                    'message' => 'success',
                    'data' => Transaksi::where('no_resi', $noResi)->get()
                ], 200);
            } else {
                return response()->json([
                    'message' => 'failed',
                ], 500);
            }
        }
    }

    /**
     * Display the all resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Transaksi $transaksi)
    {
        $tanggal = $request->input('tanggal', strtotime(now()));
        $jenis = $request->input('jenis_penjualan', 'umum');
        $data = $transaksi->with(['member', 'kasir'])
            ->where(function ($query) {
                $query->where('jenis_transaksi', '=', 'penjualan')
                    ->orWhere('jenis_transaksi', '=', 'pengiriman');
            })
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->orderBy('tanggal', 'desc')->get();
        return view('admin.transaksi.daftar', [
            // 'transaksi' => $transaksi->with(['member', 'kasir'])->where('jenis_transaksi', '=', 'penjualan')->orWhere('jenis_transaksi', '=', 'pengiriman')->orderBy('tanggal', 'desc')->get(),
            'transaksi' => $data,
            'sideTitle' => 'laporan'
        ]);
    }

    public function listPembelian(Transaksi $transaksi)
    {
        return view('admin.transaksi.daftarpembelian', [
            'transaksi' => $transaksi->with(['member', 'kasir'])->where('jenis_transaksi', 'pembelian')->orderBy('tanggal', 'desc')->get(),
            'sideTitle' => 'lpembelian'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi, $kode)
    {
        $transaksi = $transaksi->with(['detail', 'piutang', 'kasir', 'member'])->find(['no_resi', $kode])->first();
        return view('admin.transaksi.showtransaksi', [
            'sideTitle' => 'show-transaksi',
            'data' => $transaksi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi, $resi = NULL)
    {
        if ($resi != NULL) {
            $data = $transaksi->with(['kasir', 'member', 'detail', 'piutang'])
                ->where('no_resi', '=', $resi)
                ->first();
            return view('admin.transaksi.edittransaksi', [
                'sideTitle' => 'daftar-transaksi',
                'data' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $transaksi->where('no_resi', '=', $request->no_resi)
            ->update([
                'tanggal' => $request->tanggal,
                'no_dpb' => $request->no_dpb,
                'donasi' => Helper::replace_money($request->donasi)
            ]);
        if ($request->has('total')) {
            $transaksi->where('no_resi', '=', $request->no_resi)
                ->update([
                    'total' =>  Helper::replace_money($request->total),
                ]);
        }
        $request->session()->flash('edit', 'succesful');
        return redirect('edit-transaksi/' . $request->no_resi);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }

    public function delete(Request $request, Transaksi $transaksi)
    {
        // cek no_resi dan update no_resi
        if (preg_match('/WY-/', $request->id_hapus)) {
            $newID = $request->id_hapus;
        } else {
            $resi = Transaksi::withTrashed()->where('no_resi', 'like', '%' . $request->id_hapus . '%')->count();
            if ($resi == 0) {
                $newID = 'D1-' . $request->id_hapus;
                $transaksi->where('no_resi', '=', $request->id_hapus)
                    ->update([
                        'no_resi' => $newID
                    ]);
            } else {
                $newID = 'D' . $resi . '-' . $request->id_hapus;
                $transaksi->where('no_resi', '=', $request->id_hapus)
                    ->update([
                        'no_resi' => $newID
                    ]);
            }
        }

        // kembalikan stock
        $data = Transaksi::with(['detail'])->withTrashed()->where('no_resi', '=', $newID)->first();
        $jenisTransaksi = $data->jenis_transaksi;
        $datas = [];
        if (count($data->detail) > 0) {
            for ($j = 0; $j < count($data->detail); ++$j) {
                if ($data->detail[$j]->is_return === 0) {
                    $datas[] = [
                        'jenis_transaksi' => $data->jenis_transaksi,
                        'id' => $data->detail[$j]->id,
                        'no_resi' => $data->detail[$j]->transaksi_id,
                        'kode_barang' => $data->detail[$j]->kode_barang,
                        'jumlah' => $data->detail[$j]->jumlah,
                        'isReturn' => $data->detail[$j]->is_return,
                    ];
                }
            }
        }
        foreach ($datas as $d) {
            $stokAwal = Barang::withTrashed()->where('kode_barang', '=', $d['kode_barang'])->first()->stok;
            if ($jenisTransaksi == 'penjualan' || $jenisTransaksi == 'pengiriman') {
                $barang = Barang::where('kode_barang', '=', $d['kode_barang'])
                    ->update([
                        'stok' => floatval(floatval($stokAwal) + floatval($d['jumlah']))
                    ]);
            } else if ($jenisTransaksi == 'pembelian') {
                $barang = Barang::where('kode_barang', '=', $d['kode_barang'])
                    ->update([
                        'stok' => floatval(floatval($stokAwal) - floatval($d['jumlah']))
                    ]);
            }
            $detail = DetailTransaksi::where('id', '=', $d['id'])
                ->update([
                    'is_return' => 1
                ]);
        }

        // cek keberhasilan menghapus transaksi
        if ($transaksi->where('no_resi', $newID)->delete()) {
            // hapus detail piutang
            $piutang = new DetailPiutang;
            $piutang->where('transaksi_id', $request->id_hapus)->delete();
            $request->session()->flash('hapus', 'succesful');
            if ($request->jenis_hapus === 'penjualan') {
                return redirect('daftar-transaksi');
            } else if ($request->jenis_hapus === 'pembelian') {
                return redirect('daftar-transaksi-pembelian');
            }
        } else {
            $request->session()->flash('hapus', 'unsuccess');
            if ($request->jenis_hapus === 'penjualan') {
                return redirect('daftar-transaksi');
            } else if ($request->jenis_hapus === 'pembelian') {
                return redirect('daftar-transaksi-pembelian');
            }
        }
    }

    public function member_piutang($kode)
    {
        $transaksi = Transaksi::with(['member', 'kasir', 'detail', 'piutang'])->where(['member_id' => $kode, 'is_lunas' => '0'])->get();
        return response()->json([
            'message' => 'success',
            'data' => $transaksi
        ]);
    }

    public function daftar_piutang()
    {
        return view('admin.transaksi.daftarpiutang', [
            'sideTitle' => 'daftarpiutang',
            'data' => Transaksi::with(['kasir', 'member', 'detail', 'piutang'])
                ->where('is_lunas', '=', '0')
                ->where(function ($query) {
                    $query->where('jenis_transaksi', '=', 'penjualan')
                        ->orWhere('jenis_transaksi', '=', 'pengiriman');
                })
                ->orderBy('tanggal', 'desc')
                ->get()
        ]);
    }

    public function daftar_hutang()
    {
        return view('admin.transaksi.daftarhutang', [
            'sideTitle' => 'daftarhutang',
            'data' => Transaksi::with([
                'kasir', 'member', 'detail', 'piutang'
            ])->where([
                'jenis_transaksi' => 'pembelian',
                'is_lunas' => '0'
            ])
                ->orderBy('tanggal', 'desc')
                ->get()
        ]);
    }

    public function __retail()
    {
        $barang = Barang::with('satuan')->get();
        $member = Member::where('jenis_member', 'customer')->where('unit', '!=', 0)->get();
        $sideTitle = "retail";
        return view('admin.transaksi.retail', [
            'barang' => $barang,
            'member' => $member,
            'sideTitle' => $sideTitle
        ]);
    }

    public function printstruk($resi = NULL)
    {
        if ($resi == NULL) {
            $data = Transaksi::with(['kasir', 'member'])
                ->whereDate('tanggal', '=', now())
                ->where(function ($query) {
                    $query->where('is_print', '=', 0)
                        ->orWhere('jenis_transaksi', '=', 'pengiriman');
                })
                ->orderBy('jenis_transaksi', 'asc')
                ->get();
        } else {
            $data = Transaksi::with(['kasir', 'member', 'piutang', 'detail'])->where('no_resi', '=', $resi)->get();
        }
        // return response()->json([
        //     'data' => $data
        // ]);
        return view('admin.transaksi.printstruk', [
            'data' => $data,
            'faktur' => $resi,
            'sideTitle' => 'printstruk'
        ]);
    }
}
