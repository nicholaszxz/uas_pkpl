<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Jquery cdn -->
    <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>

    <!-- Jquery QR Code -->
    <script src="{{ asset('assets/js/jquery.qrcode.min.js') }}"></script>

    <style>
        * {
            font-size: 0.88rem;
            /* font-family: Arial, Helvetica, sans-serif; */
        }

        table.border-table {
            border-collapse: collapse;
            /* font-family: Arial, Helvetica, sans-serif; */
        }

        table.border-table td,
        table.border-table th {
            border: 1px solid black;
            /* font-family: Arial, Helvetica, sans-serif; */
        }

        .text-center {
            text-align: center;
            /* font-family: Arial, Helvetica, sans-serif; */
        }

    </style>

    <title>Print Faktur</title>
</head>

<body style="width: 100%">

    <?php
    $tpiutang = 0;
    $bayar = 0;
    $total = 0;
    ?>
    @foreach ($member as $transaksi)
        <?php $tpiutang += $transaksi->total; ?>
        @foreach ($transaksi->piutang as $piutang)
            <?php $bayar += $piutang->uang; ?>
        @endforeach
        <?php $total = $tpiutang - $bayar; ?>
    @endforeach

    <table id="headFaktur" style="width: 100%; padding-top: 40px">
        <tr>
            <td class="text-center"><strong>PIUTANG</strong></td>
        </tr>
    </table>

    <table class="" id="profil" style="width: 100%; margin-top: 10px">
        <tr>
            <td style="text-align: right; width: 43%">
                <img src='{{ asset('assets/img/icon/logo.png') }}' alt='AHS Asean Pasifik' style="width: 60px">
            </td>
            <td style="text-align: left; width: 50%">
                <strong>AHS Asean Pasifik</strong>
            </td>
        </tr>
    </table>

    <div style="display: flex; margin-left: 20px">
        <table id="dataMember" style="margin: 20px 0 0 20px">
            <tr>
                <td>ID User</td>
                <td>:</td>
                <td>{{ $data->member->nama . ' | ' . $data->member->kode_member }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ date('d M Y', strtotime($data->tanggal)) }}</td>
            </tr>
            <tr>
                <td>Jatuh Tempo</td>
                <td>:</td>
                <td>{{ date('d M Y', strtotime('+30 days', strtotime($data->tanggal))) }}</td>
            </tr>
        </table>

        <table id="dataFaktur" style="margin-top: 20px; position: absolute; right: 80px; display: inline-block">
            <tr>
                <td>Faktur no</td>
                <td>:</td>
                <td>{{ $data->no_resi }}</td>
            </tr>
            <tr>
                <td>ID Admin</td>
                <td>:</td>
                <td>{{ $data->kasir->name . ' | ' . $data->kasir->id }}</td>
            </tr>
        </table>
    </div>

    <table id="dataBarang" style="margin: 20px 20px 0; width: 95%">
        @if (count($data->piutang) != 0)
        <tr>
            <td><strong>Cicilan ke-{{ count($data->piutang) }}</strong></td>
        </tr>
        @endif
    </table>
    <table class="border-table" id="dataBarang" style="margin: auto; width: 83%">
        @if (count($data->piutang) == 0 || date('dmy', strtotime($data->tanggal)) == date('dmy', strtotime($data->piutang[count($data->piutang) - 1]->tanggal)))
            <thead>
                <th scope="col">No.</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Jumlah Item</th>
                <th scope="col">Harga</th>
                <th scope="col">Total</th>
            </thead>
        @endif
        <tbody>
            @if (count($data->piutang) == 0 || date('dmy', strtotime($data->tanggal)) == date('dmy', strtotime($data->piutang[count($data->piutang) - 1]->tanggal)))
                @foreach ($data->detail as $barang)
                <tr>
                    <th scope="col">{{ $loop->iteration }}</th>
                    <td class="text-center">{{ $barang->kode_barang }}</td>
                    <td style="text-align: left">{{ $barang->nama_barang }}</td>
                    <td class="text-center">{{ $helper->money_format($barang->jumlah) . ' ' . $barang->satuan }}</td>
                    <td style="text-align: right">{{ $helper->money_format($barang->harga / $barang->jumlah, 'Rp ') }}</td>
                    <td style="text-align: right">{{ $helper->money_format($barang->harga, 'Rp ') }}</td>
                </tr>
                @endforeach
            @endif
            <tr>
                <th scope="col" colspan="5" style="text-align: right">Total Piutang</th>
                <td style="text-align: right">{{ $helper->money_format($data->total, 'Rp ') }}</td>
            </tr>
            <tr>
                <?php $tp = 0; ?>
                <th scope="col" colspan="5" style="text-align: right">Pembayaran Sebelumnya</th>
                <td style="text-align: right">
                    @foreach ($data->piutang as $piutang)
                        @if (!$loop->last)
                            <?php $tp += $piutang->uang; ?>
                        @endif
                    @endforeach
                    {{ $helper->money_format($tp, 'Rp ') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div style="display: flex">
        <table style="width: 80%; margin: 30px 60px;">
            <tr>
                <td style="width: 18%"><span style="border-bottom: 1px solid black">Pembeli</span></td>
                <td><span style="border-bottom: 1px solid black">Admin</span></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 80px">
                    <p>Jl. KL Yos Sudarso KM 6 No. 132</p>
                </td>
            </tr>
        </table>

        <table style="display: inline-block; margin: 20px 0; position: absolute; right: 80px;">
            <?php $sp = 0; ?>
            <tr>
                <td>Saldo Awal</td>
                <td>:</td>
                <td>
                    @foreach ($data->piutang as $piutang)
                        @if (!$loop->last)
                            <?php $sp += $piutang->uang; ?>
                        @endif
                    @endforeach
                    <?php $sp = $data->total - $sp; ?>
                    {{ $helper->money_format($sp < 0 ? 0 : $sp, 'Rp ') }}
                </td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td>:</td>
                <td>
                    @if (count($data->piutang) != 0)
                        {{ $helper->money_format($bayar = $data->piutang[count($data->piutang) - 1]->uang, 'Rp ') }}
                    @else
                        <?php $bayar = 0; ?>
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td>:</td>
                <td>{{ $helper->money_format($kembali = $bayar - $sp < 0 ? 0 : $bayar - $sp, 'Rp ') }}</td>
            </tr>
            <tr>
                <td>Sisa Piutang Faktur</td>
                <td>:</td>
                <td>{{ $helper->money_format($sisa = $sp - $bayar < 0 ? 0 : $sp - $bayar, 'Rp ') }}</td>
            </tr>
            <tr>
                <td>Sisa Piutang Keseluruhan</td>
                <td>:</td>
                <td>{{ $helper->money_format($total, 'Rp ') }}</td>
            </tr>
            @if ($data->is_lunas == '1')
                <tr>
                    <td colspan="3" style="text-align: right; padding: 12px; font-size: 1rem">LUNAS PER FAKTUR</td>
                </tr>
            @endif
        </table>
    </div>

    <script>
        $(document).ready(function() {

            let d = new Date();
            let month = d.getMonth() + 1;
            let day = d.getDate();
            let outputDate = (day < 10 ? '0' : '') + day + '-' +
                (month < 10 ? '0' : '') + month + '-' +
                d.getFullYear();

            $('#qrcodeStruk').qrcode({
                width: 60,
                height: 60,
            });

            window.print();

        })

    </script>
</body>

</html>
