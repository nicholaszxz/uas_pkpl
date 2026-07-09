<?php

use App\Helper\Helper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanBarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailPiutangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Models\Barang;
use App\Models\DetailPiutang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard', [
            'sideTitle' => 'dashboard'
        ]);
    })->name('home');

    Route::get('login', function () {
        return view('admin.login');
    });

    // Route Transaksi
    Route::group([''], function () {
        Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi');

        Route::get('edit-transaksi/{any?}', [TransaksiController::class, 'edit'])->name('edit-transaksi');

        Route::post('update-transaksi', [TransaksiController::class, 'update'])->name('update-transaksi');

        Route::post('hapus-transaksi', [TransaksiController::class, 'delete'])->name('hapus-transaksi');

        Route::get('print-struk/{resi?}', [TransaksiController::class, 'printstruk'])->name('printstruk');

        Route::get('pembelian', [TransaksiController::class, '__pembelian'])->name('pembelian');

        Route::get('get-no-dpb', function () {
            return response()->json([
                'no_dpb' => Transaksi::generateDpb()
            ]);
        });

        Route::get('piutang', [DetailPiutangController::class, 'index'])->name('piutang');

        Route::get('hutang', [DetailPiutangController::class, 'hutang'])->name('hutang');

        Route::match(['get', 'post'], 'input-saldo-awal-piutang', [DetailPiutangController::class, 'sa_piutang'])->name('sa-piutang');

        Route::match(['get', 'post'], 'input-saldo-awal-hutang', [DetailPiutangController::class, 'sa_hutang'])->name('sa-hutang');

        Route::get('get-piutang/{any}', [DetailPiutangController::class, 'show']);

        Route::post('store-piutang', [DetailPiutangController::class, 'store']);

        Route::get('struk-piutang/{resi}/{idPiutang}/{saldoAwal}/{sisa}', function ($resi, $idPiutang, $saldoAwal, $sisa) {
            $transaksi = Transaksi::with(['detail', 'kasir', 'member', 'piutang'])->where('no_resi', $resi)->get();
            return view('admin.transaksi.strukpiutang', [
                'data' => $transaksi,
                'idPiutang' => $idPiutang,
                'saldoAwal' => $saldoAwal,
                'sisa' => $sisa
            ]);
        });

        Route::get('show-barang-transaksi/{any}', [TransaksiController::class, 'showBarang']);

        Route::post('simpan-transaksi', [TransaksiController::class, 'store']);

        Route::get('check-id-member/{kode}', function ($kode) {
            return \App\Models\Member::where(['kode_member' => $kode])->first();
        });

        Route::get('getall-member', [TransaksiController::class, 'getMember']);

        Route::get('getall-supplier', [TransaksiController::class, 'getSupplier']);

        Route::get('getall-barang', [TransaksiController::class, 'getBarang']);

        Route::get('daftar-transaksi', [TransaksiController::class, 'list'])->name('laporan');

        Route::get('daftar-transaksi-pembelian', [TransaksiController::class, 'listPembelian'])->name('daftar-pembelian');

        Route::get('show-transaksi/{any}', [TransaksiController::class, 'show']);

        Route::get('download-transaksi', [TransaksiController::class, '']);

        Route::get('transaksi-pdf/{member}', [PDFController::class, 'laporan'])->name('download-pdf');
        Route::get('laporan-transaksi/{member}', function ($kodeMember) {
            $member = \App\Models\Member::where(['kode_member' => $kodeMember])->first();
            $transaksi = Transaksi::with(['kasir', 'detail', 'piutang'])->where(['member_id' => $kodeMember])->get();
            return view('admin.transaksi.laporan', [
                'member' => $member,
                'transaksi' => $transaksi,
                'num' => 1
            ]);
        });

        Route::get('pdf-pembelian/{resi}', [PDFController::class, 'pembelian']);

        Route::get('get-member-piutang/{kode}', [TransaksiController::class, 'member_piutang']);

        Route::get('get-member-search', [MemberController::class, 'member_search']);

        Route::get('get-supplier-search', [MemberController::class, 'supplier_search']);

        Route::get('test-struk/{any}/{total?}/{uang?}/{kembali?}', function ($kode, $total = 0, $uang = 0, $kembali = 0) {
            $data = Transaksi::with(['detail', 'kasir', 'member'])->where('no_resi', $kode)->get();
            return view('admin.transaksi.test', [
                'data' => $data,
                'total' => $total,
                'uang' => $uang,
                'kembali' => $kembali
            ]);
        });

        Route::get('test-laporan', function () {
            return view('admin.transaksi.testlaporan');
        });

        Route::get('json-laporan-harian', function () {
            return response()->json([
                'data' => Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->whereDate('tanggal', now())->get()
            ]);
        });

        Route::get('laporan-harian-penjualan', [PDFController::class, 'lpj_harian'])->name('lpj-harian');

        Route::get('laporan-harian-pembelian', [PDFController::class, 'lpb_harian'])->name('lpb-harian');

        Route::get('daftar-piutang', [TransaksiController::class, 'daftar_piutang'])->name('d-piutang');

        Route::get('laporan-piutang', [PDFController::class, 'lp_piutang'])->name('lp-piutang');

        Route::get('mutasi-piutang', [PDFController::class, 'm_piutang'])->name('m-piutang');

        Route::get('daftar-hutang', [TransaksiController::class, 'daftar_hutang'])->name('d-hutang');

        Route::get('laporan-hutang', [PDFController::class, 'lp_hutang'])->name('lp-hutang');

        Route::get('mutasi-hutang', [PDFController::class, 'm_hutang'])->name('m-hutang');

        Route::get('transaksi-retail', [TransaksiController::class, '__retail'])->name('retail');

        Route::get('surat-jalan/{any?}', [PDFController::class, 's_jalan'])->name('s-jalan');

        Route::get('buku-penjualan', [PDFController::class, 'bk_penjualan'])->name('buku-penjualan');
        Route::get('buku-pembelian', [PDFController::class, 'bk_pembelian'])->name('buku-pembelian');
        Route::get('bulanan-piutang', [PDFController::class, 'bln_piutang'])->name('bln-piutang');
        Route::get('bulanan-hutang', [PDFController::class, 'bln_hutang'])->name('bln-hutang');
    });

    Route::get('jenis-barang', [JenisBarangController::class, 'index'])->name('jenis');
    Route::get('show-jenis-barang/{id}', [JenisBarangController::class, 'show']);
    Route::post('store-jenis-barang', [JenisBarangController::class, 'store']);
    Route::post('update-jenis-barang', [JenisBarangController::class, 'update']);

    Route::get('stok', [PDFController::class, 'son']);

    Route::get('stok-pdf', [PDFController::class, 'stok']);

    Route::get('test-stok', function () {
        return view('admin.stok.testlaporan');
    });

    // Route Barang
    Route::group([''], function () {
        Route::get('daftar-barang', [BarangController::class, 'index'])->name('barang');
        Route::post('store-barang', [BarangController::class, 'store']);
        Route::get('show-barang/{any}', [BarangController::class, 'show']);
        Route::post('update-barang', [BarangController::class, 'update']);
        Route::delete('delete-barang/{any}', [BarangController::class, 'delete']);
    });

    // Route Satuan Barang
    Route::group([''], function () {
        Route::post('store-satuan', [SatuanBarangController::class, 'store']);
        Route::get('show-satuan/{any}', [SatuanBarangController::class, 'show']);
        Route::post('update-satuan', [SatuanBarangController::class, 'update']);
        Route::delete('delete-satuan/{any}', [SatuanBarangController::class, 'delete']);
    });

    // Route Supplier
    Route::get('daftar-supplier', [MemberController::class, 'supplier'])->name('supplier');

    Route::get('faktur-piutang/{any?}', function ($resi = null) {
        $resi = $resi == null ? 'WY-220321002' : $resi;
        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->where(['no_resi' => $resi])->first();
        // $tawal = $total * 100 / (100 - $diskon);
        // $kembali = $data->uang - $data->total;
        return view('admin.transaksi.fakturpiutang', [
            'data' => $data,
            'member' => Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->where(['member_id' => $data->member_id, 'is_lunas' => '0'])->get()
        ]);
    });

    Route::get('faktur-retail/{any?}', function ($resi = null) {
        $resi = $resi == null ? 'WY-220321002' : $resi;
        $data = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->where(['no_resi' => $resi])->first();
        // $tawal = $total * 100 / (100 - $diskon);
        // $kembali = $data->uang - $data->total;
        return view('admin.transaksi.fakturretail', [
            'data' => $data
        ]);
    });

    // Route Member
    Route::group([''], function () {
        Route::get('daftar-member', [MemberController::class, 'index'])->name('member');
        Route::post('store-member', [MemberController::class, 'store']);
        Route::delete('delete-member/{any}', [MemberController::class, 'delete']);
        Route::get('show-member/{any}', [MemberController::class, 'show']);
        Route::post('update-member', [MemberController::class, 'update']);
        Route::get('getname-member/{any?}', function ($any = NULL) {
            // return date('d') == date('d', strtotime(new Carbon('last day of last month'))) ? 'true' : 'false';
            // return strtotime(date('Fri Apr 23 2021 11:51:00 GMT+0700 (Western Indonesia Time)'));
            $data = Transaksi::with(['detail'])->onlyTrashed()->orderBy('tanggal', 'desc')->get();
            $datas = [];
            for ($i = 0; $i < count($data); ++$i) {
                if (count($data[$i]->detail) > 0) {
                    for ($j = 0; $j < count($data[$i]->detail); ++$j) {
                        if ($data[$i]->detail[$j]->is_return === 0) {
                            $datas[] = [
                                'id' => $data[$i]->detail[$j]->id,
                                'no_resi' => $data[$i]->detail[$j]->transaksi_id,
                                'jenis_transaksi' => $data[$i]->jenis_transaksi,
                                'kode_barang' => $data[$i]->detail[$j]->kode_barang,
                                'jumlah' => $data[$i]->detail[$j]->jumlah,
                                'isReturn' => $data[$i]->detail[$j]->is_return,
                            ];
                        }
                    }
                }
            }
            if ($any == 'return') {
                foreach ($datas as $d) {
                    $stokAwal = Barang::withTrashed()->where('kode_barang', '=', $d['kode_barang'])->first()->stok;
                    if ($datas == 'penjualan' || $datas == 'pengiriman') {
                        $barang = Barang::where('kode_barang', '=', $d['kode_barang'])
                            ->update([
                                'stok' => floatval(floatval($stokAwal) + floatval($d['jumlah']))
                            ]);
                    } else if ($datas == 'pembelian') {
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
            }
            return response()->json([
                // 'data' => Transaksi::select('no_resi')->whereBetween(DB::raw('DATE(tanggal)'), ['2020-04-14', '2021-04-15'])->count()
                'data' => $datas
            ]);
        });
    });

    Route::get('just-check-something', [PDFController::class, 'contoh',]);

    Route::get('contoh', [PDFController::class, 'contoh']);

    // Route User
    Route::middleware('auth')->group(function () {
        Route::get('daftar-user', [UserController::class, 'index'])->name('user');
        Route::post('store-user', [UserController::class, 'store']);
        Route::delete('delete-user/{any}', [UserController::class, 'delete']);
        Route::get('show-user/{any}', [UserController::class, 'show']);
        Route::post('update-user', [UserController::class, 'update']);
        Route::post('repassword-user', [UserController::class, '_repassword']);
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
