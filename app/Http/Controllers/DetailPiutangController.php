<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailPiutang;
use App\Models\Member;
use App\Helper\Helper;
use Illuminate\Support\Facades\Auth;

class DetailPiutangController extends Controller
{
    public function index()
    {
        $sideTitle = "piutang";
        return view('admin.transaksi.piutang', [
            'sideTitle' => $sideTitle
        ]);
    }

    public function hutang()
    {
        $sideTitle = "hutang";
        return view('admin.transaksi.hutang', [
            'sideTitle' => $sideTitle
        ]);
    }

    public function show($resi)
    {
        $transaksi = Transaksi::with(['kasir', 'member', 'detail', 'piutang'])->where(['no_resi' => $resi, 'is_lunas' => '0'])->get();

        if ($transaksi->count() > 0) {
            return response()->json([
                'message' => 'success',
                'data' => $transaksi
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $noResi = $request->no_resi;
        $tanggal = now();
        $idKasir = Auth::user()->id;

        $piutang = new DetailPiutang;
        $piutang->transaksi_id = $noResi;
        $piutang->tanggal = $request->tanggal == '' ? $tanggal : $request->tanggal;
        $piutang->kasir_id = $idKasir;
        $piutang->uang = $request->uang;
        $piutang->save();

        if ($piutang) {

            if ($request->is_lunas == '1') {
                Transaksi::where(['no_resi' => $noResi])->update([
                    'is_lunas' => '1',
                    'tanggal_lunas' => now()
                ]);
            } else {
                Transaksi::where(['no_resi' => $noResi])->update([
                    'tanggal_lunas' => now()
                ]);
            }

            return response()->json([
                'message' => 'success',
                'data' => $piutang
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed'
            ], 500);
        }
    }

    public function sa_piutang(Request $request)
    {
        if ($request->isMethod('post')) {
            $noResi = Transaksi::incrementId();
            $idKasir = Auth::user()->id;
            $piutang = new Transaksi;
            $piutang->no_resi = $request->noFaktur == '' ? $noResi : $request->noFaktur;
            $piutang->tanggal = $request->tanggal == '' ? now() : date_format(date_create($request->tanggal), 'Y-m-d H:i:s');
            if ($request->jenisMMT == "penjualan") {
                $piutang->jenis_transaksi = 'penjualan';
            } else {
                $piutang->jenis_transaksi = 'pengiriman';
                $piutang->jenis_mmt = $request->jenisMMT;
            }
            $piutang->kasir_id = $idKasir;
            $piutang->member_id = $request->kodeMember;
            $piutang->total = Helper::replace_money($request->total);
            $piutang->donasi = Helper::replace_money($request->donasi);
            $piutang->is_lunas = '0';
            $piutang->save();
            if ($piutang) {
                $request->session()->flash('add', 'succesful');
                return redirect('input-saldo-awal-piutang');
            } else {
                $request->session()->flash('add', 'failed');
                return redirect('input-saldo-awal-piutang');
            }
        } else {
            $member = Member::where('unit', '!=', 0)->where('nama', 'not like', '%general-%')->get();
            return view('admin.transaksi.sapiutang', [
                'member' => $member,
                'sideTitle' => 'sa-piutang'
            ]);
        }
    }

    public function sa_hutang(Request $request)
    {
        if ($request->isMethod('post')) {
            $noResi = Transaksi::incrementId();
            $idKasir = Auth::user()->id;
            $hutang = new Transaksi;
            $hutang->no_resi = $request->noFaktur == '' ? $noResi : $request->noFaktur;
            $hutang->no_dpb = $request->noDpb == '' ? Transaksi::generateDpb() : $request->noDpb;
            $hutang->tanggal = $request->tanggal == '' ? now() : date_format(date_create($request->tanggal), 'Y-m-d H:i:s');
            $hutang->jenis_transaksi = 'pembelian';
            $hutang->kasir_id = $idKasir;
            $hutang->member_id = $request->kodeMember;
            $hutang->total = Helper::replace_money($request->total);
            $hutang->donasi = Helper::replace_money($request->donasi);
            $hutang->is_lunas = '0';
            $hutang->save();
            if ($hutang) {
                $request->session()->flash('add', 'succesful');
                return redirect('input-saldo-awal-hutang');
            } else {
                $request->session()->flash('add', 'failed');
                return redirect('input-saldo-awal-hutang');
            }
        } else {
            $member = Member::where('unit', '=', 0)->where('nama', 'not like', '%general-%')->get();
            return view('admin.transaksi.sahutang', [
                'member' => $member,
                'sideTitle' => 'sa-hutang'
            ]);
        }
    }
}
