<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        * {
            font-size: 0.88rem;
        }

        table.border {
            width: 100%;
            border-collapse: collapse;
        }

        table.border,
        table.border th,
        table.border td {
            border: 1px solid black;
            font-size: 0.9rem;
        }

    </style>

</head>

<body>
    <table style="width: 100%; margin-bottom: 16px;">
        <tr>
            <td style="text-align: center">BUKU PEMBELIAN</td>
        </tr>
        <tr>
            <td style="text-align: center">AHS Asean Pasifik</td>
        </tr>
        <tr>
            <?php $bulan = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS',
            'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER']; ?>
            <td style="text-align: center">BULAN :
                PER-{{ date('d') . ' ' . $bulan[(int) date('m') - 1] . ' ' . date('Y') }}
            </td>
        </tr>
    </table>
    <table class="border">
        <thead>
            <tr>
                <th scope="col" rowspan="2" style="width: 5%">NO. URUT</th>
                <th scope="col" colspan="2" style="width: 16%">FAKTUR</th>
                <th scope="col" rowspan="2" style="width: 14%">NAMA PEMBELI</th>
                <th scope="col" rowspan="2">NAMA BARANG</th>
                <th scope="col" rowspan="2">BANYAKNYA</th>
                <th scope="col" rowspan="2">HARGA SATUAN (RP.)</th>
                <th scope="col" rowspan="2">JUMLAH HARGA (RP.)</th>
                <th scope="col" rowspan="2">TOTAL FAKTUR (RP.)</th>
                <th scope="col" rowspan="2">TANGGAL LUNAS</th>
                <th scope="col" rowspan="2">KET.</th>
            </tr>
            <tr>
                <th scope="col">TGL</th>
                <th scope="col">NOMOR</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalPenjualan = 0; ?>
            @foreach ($data as $transaksi)
                <tr>
                    <th scope="col">{{ $loop->iteration }}</th>
                    <td>{{ date('d/m/Y', strtotime($transaksi->tanggal)) }}</td>
                    <td>{{ $transaksi->no_dpb }}</td>
                    <td>{{ $transaksi->member->nama }}</td>
                    @if (count($transaksi->detail) > 0)
                        <td>{{ $transaksi->detail[0]->nama_barang }}</td>
                        <td>
                            {{ $helper->money_format($transaksi->detail[0]->jumlah) . ' ' . $transaksi->detail[0]->satuan }}
                        </td>
                        <td>
                            {{ $helper->money_format($transaksi->detail[0]->harga / $transaksi->detail[0]->jumlah) }}
                        </td>
                        <td>{{ $helper->money_format($transaksi->detail[0]->harga) }}</td>
                    @else
                        <td colspan="4"></td>
                    @endif
                    <td>
                        {{ $helper->money_format($transaksi->total) }}
                        <?php $totalPenjualan += $transaksi->total; ?>
                    </td>
                    <td style="text-align: center">
                        {{ $transaksi->is_lunas == '1' && $transaksi->tanggal_lunas != '' ? date('d/m/Y', strtotime($transaksi->tanggal_lunas)) : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $transaksi->is_lunas == '0' ? 'TENGGAT WAKTU: ' . date('d/m/y', strtotime('+30 days', strtotime($transaksi->tanggal))) : '' }}
                    </td>
                </tr>
                @if (count($transaksi->detail) > 1)
                    @foreach ($transaksi->detail as $detail)
                        @if ($loop->first)
                        @else
                            <tr>
                                <th scope="col"></th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $detail->nama_barang }}</td>
                                <td>{{ $detail->jumlah . ' ' . $detail->satuan }}</td>
                                <td>
                                    {{ $helper->money_format($detail->harga / $detail->jumlah) }}
                                </td>
                                <td>{{ $helper->money_format($detail->harga) }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                @if ($loop->last)
                    <tr>
                        <td colspan="8" style="text-align: right">TOTAL PENJUALAN (RP.)</td>
                        <td>{{ $helper->money_format($totalPenjualan) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>

</html>
