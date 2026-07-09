@extends('admin.temp.template')

@section('site-title', 'Detail Transaksi')

@section('main-contents')
    <div id="message" data-msg="{{ session('edit') }}"></div>
    <div class="row">
        <div class="col-lg">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5>DETAIL TRANSAKSI</h5>
                    <hr>
                    <div class="row">
                        <div class="row">
                            <div class="col">
                                Nomor Faktur : {{ $data->no_resi }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Jenis Transaksi :
                                @if ($data->jenis_transaksi == 'penjualan')
                                    UNIT / UMUM
                                @elseif ($data->jenis_transaksi == 'pengiriman')
                                    @if ($data->jenis_mmt == 'mmt-reguler')
                                        MMT REGULER
                                    @elseif ($data->jenis_mmt == 'mmt-area')
                                        MMT AREA
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                ID Kasir : {{ $data->kasir->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Nama Anggota : {{ $data->member->nama }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Unit Anggota : {{ $data->member->unit }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Kode MMT : {{ $data->member->no_mmt }}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12">
                            <h5>DETAIL BARANG</h5>
                        </div>
                        <div class="col">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga Satuan</th>
                                        <th scope="col">Jumlah Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->detail as $detail)
                                        <tr>
                                            <th scope="col">{{ $loop->iteration }}</th>
                                            <td style="text-align: left">{{ $detail->kode_barang }}</td>
                                            <td style="text-align: left">{{ $detail->nama_barang }}</td>
                                            <td style="text-align: left">
                                                {{ $helper->money_format($detail->jumlah) . ' ' . $detail->satuan }}
                                            </td>
                                            <td style="text-align: left">
                                                {{ $helper->money_format($detail->harga / $detail->jumlah, 'Rp ') }}
                                            </td>
                                            <td style="text-align: left">
                                                {{ $helper->money_format($detail->harga, 'Rp ') }}
                                            </td>
                                        </tr>
                                        @if ($loop->last)
                                            <tr>
                                                <td colspan="5" style="text-align: right"><strong>TOTAL FAKTUR</strong></td>
                                                <td style="text-align: left">
                                                    {{ $helper->money_format($data->total, 'Rp ') }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
