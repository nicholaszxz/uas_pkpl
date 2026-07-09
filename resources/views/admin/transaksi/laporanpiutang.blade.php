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
            font-size: 0.85rem;
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

    <title>Laporan Piutang</title>
</head>

<body>
    <div class="container">
        <div id="">
            <table id="dataMember">
                <thead>
                    <tr class="head-list">
                        <th colspan="2">
                            <h4>NOTA INKASO PIUTANG</h4>
                            <h4 style="margin-top: -16px">AHS Asean Pasifik</h4>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tanggal Penerimaan : {{ date('d-m-Y') }}</td>
                        <td>ID User : {{ $userid }}</td>
                    </tr>
                    <tr>
                        <td>Kelompok Pembeli : {{ strtoupper($kelompok) }}</td>
                        <td>No. Cetak : {{ $number }}</td>
                    </tr>
                </tbody>
            </table>
            <table id="dataTransaksi">
                <thead>
                    <tr style="height: 30px;">
                        <th scope="col" rowspan="2" style="width: 3%">NO.</th>
                        <th scope="col" colspan="2" style="width: 12%">FAKTUR</th>
                        <th scope="col" rowspan="2" style="width: 16%">NAMA PEMBELI</th>
                        <th scope="col" rowspan="2">UNIT</th>
                        <th scope="col" rowspan="2">NO. ANGGOTA</th>
                        <th scope="col" rowspan="2">TOTAL FAKTUR PIUTANG (Rp.)</th>
                        <th scope="col" rowspan="2">JUMLAH PEMBAYARAN (Rp.)</th>
                        <th scope="col" rowspan="2">SISA PIUTANG (Rp.)</th>
                        <th scope="col" rowspan="2">TANGGAL LUNAS</th>
                        <th scope="col" rowspan="2">KET.</th>
                    </tr>
                    <tr style="height: 30px;">
                        <th scope="col">TGL PB</th>
                        <th scope="col">FAKTUR</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data) <= 0)
                        <tr>
                            <td colspan="11" style="text-align: center; font-style: bold; text-transform: uppercase">
                                Tidak ada data</td>
                        </tr>
                    @endif
                    <?php
                    $tp = 0; // jumlah keseluruhan piutang
                    $tpp = 0; // jumlah keseluruhan pembayaran
                    $tsp = 0;
                    ?>
                    @foreach ($data as $transaksi)
                        @if (count($transaksi->piutang) > 0 || $transaksi->is_lunas == '0')
                            <?php $sp = 0; ?>
                            @foreach ($transaksi->piutang as $piutang)
                                <?php $sp += $piutang->uang; ?>
                            @endforeach
                            <tr class="head-list">
                                <th scope="col">
                                    {{ $loop->iteration }}</th>
                                <td>
                                    {{ date('d/m/y', strtotime($transaksi->tanggal)) }}
                                </td>
                                <td>{{ $transaksi->no_resi }}</td>
                                <td>{{ $transaksi->member->nama }}</td>
                                <td>{{ $transaksi->member->unit }}</td>
                                <td>{{ $transaksi->member->kode_mmt }}</td>
                                <td>
                                    {{ $helper->money_format($transaksi->total) }}
                                </td>
                                <td>
                                    {{ $helper->money_format($sp) }}
                                </td>
                                <td>
                                    {{ $transaksi->total - $sp <= 0 ? '-' : $helper->money_format($transaksi->total - $sp) }}
                                </td>
                                <td>
                                    {{ $transaksi->is_lunas == 1 ? date('d/m/y', strtotime($transaksi->piutang[count($transaksi->piutang) - 1]->tanggal)) : '-' }}
                                </td>
                                <td>
                                    {{ $transaksi->is_lunas == 1 ? 'LUNAS' : 'TENGGAT WAKTU: ' . date('d/m/y', strtotime('+30 days', strtotime($transaksi->tanggal))) }}
                                </td>
                            </tr>
                            <?php
                            $tp += $transaksi->total;
                            $tpp += $sp;
                            $tsp += $transaksi->total - $sp;
                            ?>
                        @endif
                        @if ($loop->last)
                            <tr>
                                <th colspan="6" style="text-align: right">TOTAL PIUTANG (Rp. )</th>
                                <td style="text-align: center">{{ $helper->money_format($tp) }}</td>
                                <td style="text-align: center">{{ $helper->money_format($tpp) }}</td>
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
