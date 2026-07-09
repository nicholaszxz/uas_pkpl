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
            font-size: 1rem;
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

    <title>Laporan Transaksi</title>
</head>

<body>
    <div class="container">
        <div class="row row-button">
            <a href="{{ route('download-pdf', $member->kode_member) }}" target="_blank"><button type="button">Download
                    PDF</button></a>
        </div>
        <div id="laporanLand">
            <table id="dataMember">
                <thead>
                    <tr class="head-list">
                        <th colspan="2">
                            <h4>Riwayat Transaksi</h4>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama: {{ $member->nama }}</td>
                        <td>Kode unit: {{ $member->kode_member }}</td>
                    </tr>
                    <tr>
                        <td>Unit: {{ $member->unit }}</td>
                        <td>Tanggal: {{ date('d-m-Y') }}</td>
                    </tr>
                </tbody>
            </table>
            <table id="dataTransaksi">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col" style="width: 24%">Invoice Transaksi</th>
                        <th scope="col">Kode Produk</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Ket</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $t)
                        @foreach ($t->detail as $detail)
                            <tr class="head-list">
                                <th scope="col">{{ $num++ }}</th>
                                <td>{{ $detail->transaksi_id }}</td>
                                <td>{{ $detail->kode_barang }}</td>
                                <td>{{ $detail->nama_barang }}</td>
                                <td>{{ $detail->jumlah . ' ' . $detail->nama_satuan }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
