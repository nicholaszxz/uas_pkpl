<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="url-global" content="{{ config('app.url') }}">

    <style>
        * {
            font-family: arial, Calibri;
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

    <title>Laporan Pembelian Harian</title>
</head>

<body>
    <div class="container">
        <div id="">
            <table id="dataMember">
                <thead>
                    <tr class="head-list">
                        <th colspan="2">
                            <h4>BUKU HARIAN PEMBELIAN</h4>
                            <h4 style="margin-top: -16px">AHS Asean Pasifik</h4>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Per Tanggal : {{ date('d-m-Y', $tanggal) }}</td>
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
                        <th scope="col" rowspan="2" style="width: 6%">JUMLAH</th>
                        <th scope="col" rowspan="2" style="width: 6%">BANYAKNYA</th>
                        <th scope="col" rowspan="2">HARGA SATUAN (Rp.)</th>
                        <th scope="col" rowspan="2">JUMLAH HARGA (Rp.)</th>
                        <th scope="col" rowspan="2">PEMBELIAN TUNAI (Rp.)</th>
                        <th scope="col" rowspan="2">PEMBELIAN KREDIT (Rp.)</th>
                        <th scope="col" rowspan="2">PEMBAYARAN KREDIT (Rp.)</th>
                        <th scope="col" rowspan="2">JATUH TEMPO</th>
                        <th scope="col" rowspan="2">KET.</th>
                    </tr>
                    <tr style="height: 30px;">
                        <th scope="col">TGL</th>
                        <th scope="col">NOMOR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 0;
                    $tp = 0;
                    $tk = 0;
                    $tc = 0;
                    ?>
                    @foreach ($data as $transaksi)
                        @if (date('dmy', strtotime($transaksi->tanggal)) == date('dmy', $tanggal))
                            <?php
                            $tcicilan = 0;
                            $tscicilan = 0;
                            ?>
                            <tr class="head-list">
                                <th scope="col" rowspan="{{ count($transaksi->detail) }}">{{ $num += 1 }}
                                </th>
                                <td rowspan="{{ count($transaksi->detail) }}">
                                    {{ date('d/m/y', strtotime($transaksi->tanggal)) }}</td>
                                <td rowspan="{{ count($transaksi->detail) }}">{{ $transaksi->no_dpb }}</td>
                                <td rowspan="{{ count($transaksi->detail) }}">{{ $transaksi->member->nama }}</td>
                                @if (count($transaksi->detail) > 0)
                                    <td>{{ $transaksi->detail[0]->nama_barang }}</td>
                                    <td>{{ $helper->money_format($transaksi->detail[0]->jumlah) . ' ' . $transaksi->detail[0]->satuan }}
                                    </td>
                                    <td>{{ $transaksi->detail[0]->harga / $transaksi->detail[0]->jumlah }}</td>
                                    <td>{{ $transaksi->detail[0]->harga }}</td>
                                @else
                                    <td colspan="4" style="text-align: center">-</td>
                                @endif
                                @if ($transaksi->is_lunas == '1' && count($transaksi->piutang) == 0)
                                    <td rowspan="{{ count($transaksi->detail) }}">{{ $transaksi->total }}</td>
                                    <td rowspan="{{ count($transaksi->detail) }}">-</td>
                                    <td rowspan="{{ count($transaksi->detail) }}">-</td>
                                    <?php $tp += $transaksi->total; ?>
                                @else
                                    <td rowspan="{{ count($transaksi->detail) }}">-</td>
                                    <td rowspan="{{ count($transaksi->detail) }}">-</td>
                                    <td rowspan="{{ count($transaksi->detail) }}">{{ $transaksi->total }}</td>
                                    @foreach ($transaksi->piutang as $piutang)
                                        <?php $tscicilan += $piutang->uang; ?>
                                        @if (date('dmy', strtotime($piutang->tanggal)) == date('dmy'))
                                            <?php $tcicilan += $piutang->uang; ?>
                                        @endif
                                    @endforeach
                                    <?php $tcicilan = $tcicilan - ($tscicilan - $transaksi->total < 0 ? 0
                                        : $tscicilan - $transaksi->total); ?> <td
                                            rowspan="{{ count($transaksi->detail) }}">
                                            {{ $tcicilan == 0 ? '-' : $tcicilan }}
                                        </td>
                                        <?php
                                        $tk += $transaksi->total;
                                        $tc += $tcicilan;
                                        ?>
                                @endif
                                <td rowspan="{{ count($transaksi->detail) }}">
                                    {{ $transaksi->is_lunas != 1 ? date('d/m/y', strtotime('+30 days', strtotime($transaksi->tanggal))) : '-' }}
                                </td>
                                <td rowspan="{{ count($transaksi->detail) }}">
                                    {{ $transaksi->is_lunas == 1 ? 'L' : '' }}
                                </td>
                            </tr>
                            @if (count($transaksi->detail) > 1)
                                @for ($i = 1; $i <= count($transaksi->detail) - 1; $i++)
                                    <tr class="head-list">
                                        <td>{{ $transaksi->detail[$i]->nama_barang }}</td>
                                        <td>{{ $helper->money_format($transaksi->detail[$i]->jumlah) . ' ' . $transaksi->detail[$i]->satuan }}
                                        </td>
                                        <td>{{ $transaksi->detail[$i]->harga / $transaksi->detail[$i]->jumlah }}</td>
                                        <td>{{ $transaksi->detail[$i]->harga }}</td>
                                    </tr>
                                @endfor
                            @endif
                        @endif
                        @if (date('dmy', strtotime($transaksi->tanggal)) != date('dmy', $tanggal) && count($transaksi->piutang) > 0)
                            @if (date('dmy', strtotime($transaksi->piutang[count($transaksi->piutang) - 1]->tanggal)) ==
                            date('dmy', $tanggal))
                            <?php
                            $tcicilan = 0;
                            $tscicilan = 0;
                            ?>
                            <tr>
                                <th scope="col" style="text-align: center">{{ $num += 1 }}</th>
                                <td style="text-align: center">
                                    {{ date('d/m/y', strtotime($transaksi->piutang[count($transaksi->piutang) - 1]->tanggal)) }}
                                </td>
                                <td style="text-align: center">{{ $transaksi->no_resi }}</td>
                                <td style="text-align: center">{{ $transaksi->member->nama }}</td>
                                <td colspan="4" style="font-style: italic; text-align: center"><strong>-</strong></td>
                                <td style="text-align: center">-</td>
                                <td style="text-align: center">-</td>
                                @foreach ($transaksi->piutang as $piutang)
                                    <?php $tscicilan += $piutang->uang; ?>
                                    @if (date('dmy', strtotime($piutang->tanggal)) == date('dmy'))
                                        <?php $tcicilan += $piutang->uang; ?>
                                    @endif
                                @endforeach
                                <?php
                                $tcicilan = $tcicilan - ($tscicilan - $transaksi->total < 0 ? 0 : $tscicilan -
                                    $transaksi->total);
                                    $tc += $tcicilan;
                                    ?>
                                    <td style="text-align: center">
                                        {{ $tcicilan == 0 ? '-' : $tcicilan }}
                                    </td>
                                    <td style="text-align: center">
                                        {{ $transaksi->is_lunas != 1 ? date('d/m/y', strtotime('+30 days', strtotime($transaksi->tanggal))) : '-' }}
                                    </td>
                                    <td style="text-align: center" rowspan="{{ count($transaksi->detail) }}">
                                        {{ $transaksi->is_lunas == 1 ? 'L' : '' }}
                                    </td>
                            </tr>
                        @endif
                    @endif
                    @if ($loop->last)
                        <tr>
                            <th colspan="9" style="text-align: right">TOTAL PEMBELIAN (Rp. )</th>
                            <td style="text-align: center">{{ $tp == 0 ? '-' : $tp }}</td>
                            <td style="text-align: center">{{ $tk == 0 ? '-' : $tk }}</td>
                            <td style="text-align: center">{{ $tc == 0 ? '-' : $tc }}</td>
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
