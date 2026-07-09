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
            font-family: Arial, Helvetica, sans-serif;
        }

        table.border-table {
            border-collapse: collapse;
            font-family: Arial, Helvetica, sans-serif;
        }

        table.border-table td,
        table.border-table th {
            border: 1px solid black;
            font-family: Arial, Helvetica, sans-serif;
        }

        .text-center {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }

    </style>

    <title>Print Faktur</title>
</head>

<body style="width: 100%">

    <table id="headFaktur" style="width: 100%; padding-top: 40px">
        <tr>
            <td class="text-center"><strong>INVOICE</strong></td>
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
                <td>Kode MMT</td>
                <td>:</td>
                <td>{{ $data->member->kode_mmt }}</td>
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
    <table class="border-table" id="dataBarang" style="margin: auto; width: 85%">
        <thead>
            <th scope="col">No.</th>
            <th scope="col">Uraian</th>
            <th scope="col">Jumlah Item</th>
            <th scope="col">Harga Satuan (Rp. )</th>
            <th scope="col">Jumlah Harga (Rp. )</th>
        </thead>
        <tbody>
            @foreach ($data->detail as $barang)
                <tr>
                    <th scope="col">{{ $loop->iteration }}</th>
                    <td style="width: 50%; text-align: left">{{ $barang->nama_barang }}</td>
                    <td class="text-center">{{ $helper->money_format($barang->jumlah) . ' ' . $barang->satuan }}</td>
                    <td style="text-align: right">{{ $helper->money_format($barang->harga / $barang->jumlah) }}</td>
                    <td style="text-align: right">{{ $helper->money_format($barang->harga) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="border: 0px"></td>
                <th style="text-align: right; padding: 10px;">Total (Rp. )</th>
                <td style="text-align: right">{{ $helper->money_format($data->total) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="border: 0px"></td>
                <th style="text-align: right; padding: 10px;">Donasi (Rp. )</th>
                <td style="text-align: right">{{ $helper->money_format($data->donasi) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="display: flex">
        <table style="width: 80%; margin: 30px 60px;">
            <tr>
                <td><span style="border-bottom: 1px solid black">Yang menerima,</span></td>
                <td style="text-align: right"><span style="border-bottom: 1px solid black">Hormat kami,</span></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 80px">
                    <p>Jl. KL Yos Sudarso KM 6 No. 132</p>
                </td>
            </tr>
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
