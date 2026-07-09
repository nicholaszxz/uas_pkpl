<?php

namespace App\Http\Controllers;

use App\Models\SatuanBarang;
use Illuminate\Http\Request;

class SatuanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $satuan = new SatuanBarang;
        $satuan->kode_barang = $request->kode_barang;
        $satuan->nama_satuan = $request->nama_satuan;
        $satuan->rasio = $request->rasio;
        $satuan->harga_beli = $request->harga_beli;
        $satuan->harga_jual = $request->harga_jual;
        $satuan->harga_supl = $request->harga_supl;
        $satuan->save();
        if ($satuan) {
            return response()->json([
                'message' => 'success',
                'data' => $satuan
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SatuanBarang  $satuanBarang
     * @return \Illuminate\Http\Response
     */
    public function show(SatuanBarang $satuanBarang, $id)
    {
        $data = $satuanBarang->find($id);
        if ($data->count() > 0) {
            return response()->json([
                'message' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SatuanBarang  $satuanBarang
     * @return \Illuminate\Http\Response
     */
    public function edit(SatuanBarang $satuanBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SatuanBarang  $satuanBarang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SatuanBarang $satuanBarang)
    {
        $satuanBarang->where('id', $request->id)
            ->update([
                'kode_barang' => $request->kode_barang,
                'nama_satuan' => $request->nama_satuan,
                'rasio' => $request->rasio,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'harga_supl' => $request->harga_supl,
            ]);
        if ($satuanBarang) {
            return response()->json([
                'message' => 'success',
                'data' => $satuanBarang
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SatuanBarang  $satuanBarang
     * @return \Illuminate\Http\Response
     */
    // Soft Delete
    public function delete(SatuanBarang $satuanBarang, $id)
    {
        if ($satuanBarang->find($id)->delete()) {
            return response()->json([
                'message' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed'
            ], 500);
        }
    }
    // Permanent Delete
    public function destroy(SatuanBarang $satuanBarang)
    {
        //
    }
}
