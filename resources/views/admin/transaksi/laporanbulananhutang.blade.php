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
            <td style="text-align: center">LAPORAN BULANAN HUTANG</td>
        </tr>
        <tr>
            <td style="text-align: center">AHS Asean Pasifik</td>
        </tr>
        <tr>
            <?php $bulan = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS',
            'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER']; ?>
            <td style="text-align: center">BULAN :
                PER - {{ $bulan[(int) date('m') - 1] . ' ' . date('Y') }}
            </td>
        </tr>
    </table>
    <table class="border">
        <thead>
            <tr>
                <th scope="col" rowspan="2" style="width: 5%">NO. URUT</th>
                <th scope="col" colspan="2" style="width: 6%">FAKTUR</th>
                <th scope="col" rowspan="2" style="width: 14%">NAMA PEMBELI</th>
                <th scope="col" rowspan="2">TOTAL FAKTUR</th>
                <th scope="col" rowspan="2">SISA PIUTANG</th>
                <th scope="col" rowspan="2">TANGGAL LUNAS</th>
                <th scope="col" rowspan="2">KET.</th>
            </tr>
            <tr>
                <th scope="col">TGL</th>
                <th scope="col">NOMOR</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalfaktur = 0;
            $totalsisa = 0;
            ?>
            @foreach ($data as $transaksi)
                <tr>
                    <th scope="col">{{ $loop->iteration }}</th>
                    <td style="text-align: center">{{ date('d/m/y', strtotime($transaksi->tanggal)) }}</td>
                    <td style="text-align: center">{{ $transaksi->no_dpb }}</td>
                    <td style="text-align: center">{{ $transaksi->member->nama }}</td>
                    <td style="text-align: right">{{ $helper->money_format($transaksi->total, 'Rp ') }}</td>
                    <?php $totalfaktur += $transaksi->total; ?>
                    <td style="text-align: right">
                        <?php $jumlahbayar = 0; ?>
                        @foreach ($transaksi->piutang as $piutang)
                            <?php $jumlahbayar += $piutang->uang; ?>
                        @endforeach
                        <?php $totalsisa += $transaksi->total - $jumlahbayar; ?>
                        {{ $helper->money_format($transaksi->total - $jumlahbayar, 'Rp ') }}
                    </td>
                    <td style="text-align: center">
                        {{ $transaksi->is_lunas == '1' ? date('d-m-Y', strtotime($transaksi->tanggal_lunas)) : '-' }}
                    </td>
                    <td></td>
                </tr>
                @if (count($transaksi->piutang) > 0)
                    <?php $nocicilan = 0; ?>
                    @foreach ($transaksi->piutang as $piutang)
                        <?php $nocicilan += 1; ?>
                        <tr>
                            <td></td>
                            <td style="text-align: center">{{ date('d/m/y', strtotime($piutang->tanggal)) }}</td>
                            <td style="text-align: right">Ciciclan ke-{{ $nocicilan }}</td>
                            <td style="text-align: left">{{ $helper->money_format($piutang->uang, 'Rp ') }}</td>
                            <td colspan="4"></td>
                        </tr>
                    @endforeach
                @endif
                @if ($loop->last)
                    <tr>
                        <td colspan="4" style="text-align: right"><strong>TOTAL</strong></td>
                        <td style="text-align: right">{{ $helper->money_format($totalfaktur, 'Rp ') }}</td>
                        <td style="text-align: right">{{ $helper->money_format($totalsisa, 'Rp ') }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>

</html>
