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

        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        p {
            page-break-after: always;
        }

        p:last-child {
            page-break-after: never;
        }

    </style>

    <title>MUTASI PIUTANG</title>
</head>

<body>
    {{-- <header>header on each page</header>
    <footer>footer on each page</footer> --}}

    <div class="container">
        <div id="">
            <table id="dataMember">
                <thead>
                    <tr class="head-list">
                        <th colspan="2">
                            <h4>MUTASI PIUTANG DAGANG UNIT REGULER</h4>
                            <h4 style="margin-top: -16px">AHS Asean Pasifik</h4>
                            <h4 style="margin-top: -16px">
                                <?php
                                $date = date('m');
                                $dateString = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI',
                                'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
                                for ($i = 0; $i <= count($dateString); $i++) { if ($date==$i) { echo $dateString[$i - 1]
                                    . ' ' . date('Y'); } } ?> </h4>
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <table id="dataTransaksi">
                <thead>
                    <tr style="height: 30px;">
                        <th scope="col" style="width: 5%">NO.</th>
                        <th scope="col" style="width: 25%">NAMA</th>
                        <th scope="col" style="width: ">SALDO AWAL</th>
                        <th scope="col" style="width: ">PENAMBAHAN</th>
                        <th scope="col" style="width: ">PEMBAYARAN</th>
                        <th scope="col" style="width: ">SALDO AKHIR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $number = 0;
                    $tsaldoawal = 0;
                    $tpenambahan = 0;
                    $tpembayaran = 0;
                    $tsaldoakhir = 0;
                    ?>
                    @foreach ($unit as $u)
                        <?php
                        $tsaldoawalunit = 0;
                        $tpenambahanunit = 0;
                        $tpembayaranunit = 0;
                        $tsaldoakhirunit = 0;
                        ?>
                        <tr>
                            <th scope="col" colspan="6" style="text-align: left">UNIT {{ $u->unit }}</th>
                        </tr>
                        @foreach ($member as $m)
                            @if ($m->unit == $u->unit)
                                <?php
                                $transaksimember = 0;
                                $saldoawal = 0;
                                $penambahan = 0;
                                $pembayaran = 0;
                                ?>
                                @foreach ($transaksi as $t)
                                    @if ($t->member_id == $m->kode_member)
                                        @if ($t->is_lunas == '0' || date('my', strtotime($t->tanggal_lunas)) == date('my'))
                                            <?php
                                            $transaksimember += 1;
                                            $sbayar = 0;
                                            $bayar = 0;
                                            $tbayar = 0;
                                            ?>
                                            @if (date('my', strtotime($t->tanggal)) != date('my'))
                                                @foreach ($t->piutang as $piutang)
                                                    @if (date('my', strtotime($piutang->tanggal)) != date('my'))
                                                        <?php $sbayar += $piutang->uang; ?>
                                                    @endif
                                                @endforeach
                                                <?php $saldoawal += $t->total - $sbayar; ?>
                                            @endif
                                            @foreach ($t->piutang as $piutang)
                                                <?php $tbayar += $piutang->uang; ?>
                                                @if (date('my', strtotime($piutang->tanggal)) == date('my'))
                                                    <?php $bayar += $piutang->uang; ?>
                                                @endif
                                            @endforeach
                                            <?php
                                            $penambahan += $t->total;
                                            $tbayar = $tbayar > $t->total ? $tbayar - $t->total : 0;
                                            $bayar = $bayar - $tbayar;
                                            $pembayaran += $bayar;
                                            ?>
                                        @endif
                                    @endif
                                @endforeach
                                @if ($transaksimember > 0)
                                    <?php
                                    $tsaldoawalunit += $saldoawal;
                                    $tpenambahanunit += $penambahan - $saldoawal;
                                    $tpembayaranunit += $pembayaran;
                                    $tsaldoakhirunit += $penambahan - $pembayaran;
                                    ?>
                                    <tr>
                                        <td style="text-align: right">{{ ++$number }}</td>
                                        <td>{{ $m->nama }}</td>
                                        <td style="text-align: right">
                                            {{ $helper->money_format($saldoawal) }}</td>
                                        <td style="text-align: right">
                                            {{ $helper->money_format($penambahan - $saldoawal) }}</td>
                                        <td style="text-align: right">{{ $helper->money_format($pembayaran) }}</td>
                                        <td style="text-align: right">
                                            {{ $helper->money_format($penambahan - $pembayaran) }}</td>
                                    </tr>
                                @endif
                            @endif
                            @if ($loop->last)
                                <tr>
                                    <th scope="col" colspan="2">TOTAL</th>
                                    <td style="text-align: right">
                                        <strong>{{ $helper->money_format($tsaldoawalunit) }}</strong>
                                    </td>
                                    <td style="text-align: right">
                                        <strong>{{ $helper->money_format($tpenambahanunit) }}</strong>
                                    </td>
                                    <td style="text-align: right">
                                        <strong>{{ $helper->money_format($tpembayaranunit) }}</strong>
                                    </td>
                                    <td style="text-align: right">
                                        <strong>{{ $helper->money_format($tsaldoakhirunit) }}</strong>
                                    </td>
                                </tr>
                                <?php
                                $tsaldoawal += $tsaldoawalunit;
                                $tpenambahan += $tpenambahanunit;
                                $tpembayaran += $tpembayaranunit;
                                $tsaldoakhir += $tsaldoakhirunit;
                                ?>
                            @endif
                        @endforeach
                        @if ($loop->last)
                            <tr>
                                <td colspan="6">-</td>
                            </tr>
                            <tr>
                                <th scope="col" colspan="2">TOTAL SEMUA</th>
                                <td style="text-align: right">
                                    <strong>{{ $helper->money_format($tsaldoawal) }}</strong>
                                </td>
                                <td style="text-align: right">
                                    <strong>{{ $helper->money_format($tpenambahan) }}</strong>
                                </td>
                                <td style="text-align: right">
                                    <strong>{{ $helper->money_format($tpembayaran) }}</strong>
                                </td>
                                <td style="text-align: right">
                                    <strong>{{ $helper->money_format($tsaldoakhir) }}</strong>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
