<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body style="color: #000000">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Nama Pembeli</th>
                <th scope="col">Total</th>
                <th scope="col">KET</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 0; ?>
            <!-- jumlah perulangan tanggal -->
            @for ($i = 1; $i <= $akhir_bulan; $i++)
                <?php
                $sum = 0; // jumlah per tanggal
                $total = 0; // total per tanggal
                $dataTransaksi = [];
                ?>
                @foreach ($data as $transaksi) @if (date('dmy', strtotime($transaksi->tanggal)) == $i . date('my') || date('dmy', strtotime($transaksi->tanggal_lunas)) == $i . date('my'))
                    <?php
                    $sum += 1;
                    $dataTransaksi[] = $transaksi;
                    $loopTanggal = $i . date('my');
                    ?> @endif
                @endforeach
                @if ($sum > 0)
                    <?php $num += 1; ?>
                    <tr>
                        <th scope="col">{{ $num }}</th>
                        <td colspan="4" style="border-bottom: 1px solid black; border-top: 1px solid black">
                            {{ date('d/m/Y', strtotime($i . date('-m-Y'))) }}
                        </td>
                    </tr>
                    @foreach ($dataTransaksi as $transaksi)
                        @if (date('dmy', strtotime($transaksi->tanggal)) == $i . date('my') || date('dmy', strtotime($transaksi->tanggal_lunas)) == $i . date('my'))
                            @if ($transaksi->is_lunas == '1' && $transaksi->tanggal_lunas == '')
                                <tr>
                                    <th scope="col"></th>
                                    <td></td>
                                    <td>{{ $transaksi->no_resi }}</td>
                                    <td>{{ $helper->money_format($transaksi->total) }}</td>
                                    <td>{{ 'TUNAI' }}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    @foreach ($dataTransaksi as $transaksi)
                        @if (date('dmy', strtotime($transaksi->tanggal)) == $i . date('my') || date('dmy', strtotime($transaksi->tanggal_lunas)) == $i . date('my'))
                            @if ($transaksi->is_lunas == '1' && $transaksi->tanggal_lunas != '')
                                <tr>
                                    @if (date('dmy', strtotime($transaksi->tanggal)) != $loopTanggal)
                                        <th scope="col"></th>
                                        <td>{{ date('d/m/Y', strtotime($transaksi->tanggal)) }}</td>
                                    @else
                                        <th scope="col"></th>
                                        <td></td>
                                    @endif
                                    <td>{{ $transaksi->no_resi }}</td>
                                    <td>{{ $helper->money_format($transaksi->total) }}</td>
                                    <td>{{ 'KREDIT LUNAS' }}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    @foreach ($dataTransaksi as $transaksi)
                        @if (date('dmy', strtotime($transaksi->tanggal)) == $i . date('my') || date('dmy', strtotime($transaksi->tanggal_lunas)) == $i . date('my'))
                            @if ($transaksi->is_lunas == '0')
                                <tr>
                                    @if (date('dmy', strtotime($transaksi->tanggal)) != $loopTanggal)
                                        <th scope="col"></th>
                                        <td>{{ date('d/m/Y', strtotime($transaksi->tanggal)) }}</td>
                                    @else
                                        <th scope="col"></th>
                                        <td></td>
                                    @endif
                                    <td>{{ $transaksi->no_resi }}</td>
                                    <td>{{ $helper->money_format($transaksi->total) }}</td>
                                    <td>{{ 'KREDIT PIUTANG' }}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endfor
        </tbody>
    </table>
</body>

</html>
