<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="url-global" content="{{ config('app.url') }}">

    <style>
        * {
            font-family: arial, sans-serif;
            font-size: 0.88rem;
        }

        body {
            font-size: 0.1rem;
        }

        /* div.container {
            background-color: rgb(39, 38, 38);
        } */

        tr.list-item th {
            text-align: left
        }

        tr.head-list td {
            text-align: center
        }

        table#dataTransaksi {
            width: 100%;
            border-collapse: collapse;
        }

        table#dataTransaksi,
        table#dataTransaksi th,
        table#dataTransaksi td {
            border: 1px solid black;
            font-size: 0.9rem;
        }

        table#dataTransaksi tr {
            border: 1px solid black;
            border-width: thick;
        }

        table#dataMember {
            width: 100%;
            margin-bottom: 20px;
        }

        table#dataMember td {
            width: 50%;
        }

        tr.border-bottom td {
            border-bottom: 1px solid black;
        }

        tr.border-full td {
            border: 1px solid black;
        }

        td.border-right {
            vertical-align: top;
            border-right: 1px solid black;
        }

        div#laporanLand {
            width: 80%;
            margin: auto;
            margin-top: 40px;
            border: 1px solid black;
            padding: 12px;
        }

        div.row-button {
            width: 80%;
            margin: auto;
            margin-top: 40px;
        }

    </style>

    <title>Laporan Hutang</title>
</head>

<body>
    <div class="container">
        <div id="">
            <table id="dataMember">
                <thead>
                    <tr class="head-list">
                        <th colspan="2">
                            <h4>BUKU HUTANG</h4>
                            <h4 style="margin-top: -16px">AHS Asean Pasifik</h4>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tanggal : {{ date('d-m-Y', $tanggal) }}</td>
                        <td>No. Cetak : {{ $number }}</td>
                    </tr>
                    <tr>
                        <td>ID User : {{ $userid }}</td>
                    </tr>
                </tbody>
            </table>
            <table id="dataTransaksi">
                <thead>
                    <tr style="height: 30px;">
                        <th scope="col" rowspan="2" style="width: 3%">NO.</th>
                        <th scope="col" colspan="2" style="width: 14%">FAKTUR</th>
                        <th scope="col" rowspan="2">NAMA SUPPLIER</th>
                        <th scope="col" rowspan="2">NAMA BARANG</th>
                        <th scope="col" rowspan="2" style="width: 8%">BANYAKNYA</th>
                        <th scope="col" rowspan="2">HARGA SATUAN (Rp.)</th>
                        <th scope="col" rowspan="2">JUMLAH HARGA (Rp.)</th>
                        <th scope="col" rowspan="2">TOTAL FAKTUR (Rp.)</th>
                        <th scope="col" rowspan="2">SISA (Rp.)</th>
                        <th scope="col" rowspan="2">TANGGAL LUNAS</th>
                        <th scope="col" rowspan="2">KET.</th>
                    </tr>
                    <tr style="height: 30px;">
                        <th scope="col">TGL PB</th>
                        <th scope="col">No. DPB</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tp = 0;
                    $tsp = 0;
                    ?>
                    @foreach ($data as $transaksi)
                        @if (count($transaksi->piutang) > 0 || $transaksi->is_lunas == '0')
                            <tr class="head-list">
                                <th scope="col"
                                    rowspan="{{ count($transaksi->detail) + count($transaksi->piutang) }}">
                                    {{ $loop->iteration }}</th>
                                <td rowspan="{{ count($transaksi->detail) }}">
                                    {{ date('d/m/y', strtotime($transaksi->tanggal)) }}</td>
                                <td rowspan="{{ count($transaksi->detail) }}">{{ $transaksi->no_dpb }}</td>
                                <td rowspan="{{ count($transaksi->detail) }}">{{ $transaksi->member->nama }}</td>
                                @if (count($transaksi->detail) > 0)
                                    <td>{{ $transaksi->detail[0]->nama_barang }}</td>
                                    <td>{{ $helper->money_format($transaksi->detail[0]->jumlah) . ' ' . $transaksi->detail[0]->satuan }}
                                    </td>
                                    <td>{{ $helper->money_format((int) $transaksi->detail[0]->harga / (int) $transaksi->detail[0]->jumlah) }}
                                    </td>
                                    <td>{{ $helper->money_format($transaksi->detail[0]->harga) }}</td>
                                @else
                                    <td colspan="4" style="text-align: center">-</td>
                                @endif
                                <td rowspan="{{ count($transaksi->detail) + count($transaksi->piutang) }}">
                                    {{ $helper->money_format($transaksi->total) }}</td>
                                <td rowspan="{{ count($transaksi->detail) + count($transaksi->piutang) }}">
                                    <?php $sp = 0; ?>
                                    @foreach ($transaksi->piutang as $piutang)
                                        <?php $sp += $piutang->uang; ?>
                                    @endforeach
                                    {{ $transaksi->total - $sp <= 0 ? '-' : $helper->money_format($transaksi->total - $sp) }}
                                </td>
                                <td rowspan="{{ count($transaksi->detail) + count($transaksi->piutang) }}">
                                    {{ $transaksi->is_lunas == 1 ? date('d/m/y', strtotime($transaksi->piutang[count($transaksi->piutang) - 1]->tanggal)) : '-' }}
                                </td>
                                <td rowspan="{{ count($transaksi->detail) + count($transaksi->piutang) }}">
                                    {{ $transaksi->is_lunas == 1 ? 'LUNAS' : 'TENGGAT WAKTU: ' . date('d/m/y', strtotime('+30 days', strtotime($transaksi->tanggal))) }}
                                </td>
                            </tr>
                            @if (count($transaksi->detail) > 1)
                                @for ($i = 1; $i <= count($transaksi->detail) - 1; $i++)
                                    <tr class="head-list">
                                        <td>{{ $transaksi->detail[$i]->nama_barang }}</td>
                                        <td>{{ $helper->money_format($transaksi->detail[$i]->jumlah) . ' ' . $transaksi->detail[$i]->satuan }}
                                        </td>
                                        <td>{{ $helper->money_format((int) $transaksi->detail[$i]->harga / (int) $transaksi->detail[$i]->jumlah) }}
                                        </td>
                                        <td>{{ $helper->money_format($transaksi->detail[$i]->harga) }}</td>
                                    </tr>
                                @endfor
                            @endif
                            @foreach ($transaksi->piutang as $piutang)
                                <tr>
                                    <th scope="col" colspan="4" style="text-align: left">Cicilan
                                        ke-{{ $loop->iteration }}</th>
                                    <th scope="col" colspan="3" style="text-align: right">{{ $piutang->uang }}</th>
                                </tr>
                            @endforeach
                            <?php $tp += $transaksi->total; ?>
                            <?php $tsp += $transaksi->total - $sp; ?>
                        @endif
                        @if ($loop->last)
                            <tr>
                                <th colspan="8" style="text-align: right">TOTAL HUTANG (Rp. )</th>
                                <td style="text-align: center">{{ $helper->money_format($tp) }}</td>
                                <td style="text-align: center">{{ $helper->money_format($tsp) }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
