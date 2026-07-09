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

    <title>Surat Jalan</title>
</head>

<body>
    <div class="container">
        <div id="">
            <table id="dataMember">
                <thead>
                    <tr class="head-list">
                        <th colspan="2">
                            <h4>SURAT PENYERAHAN BARANG</h4>
                            <h4 style="margin-top: -16px">AHS Asean Pasifik</h4>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td style="text-align: left">Bandung, {{ date('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: left">Kepada Yth. :</td>
                    </tr>
                    <tr>
                        <td>UNIT : {{ $data->member->unit }}</td>
                        <td style="border-bottom: 1px solid black"></td>
                    </tr>
                    <tr>
                        <td>SPB/INV NO. : {{ $data->no_resi }}</td>
                        <td style="border-bottom: 1px solid black"></td>
                    </tr>
                </tbody>
            </table>
            <table id="dataTransaksi">
                <thead>
                    <tr style="height: 30px;">
                        <th scope="col" style="width: 5%">NO.</th>
                        <th scope="col" style="width: 50%">URAIAN</th>
                        <th scope="col" style="width: ">JUMLAH</th>
                        <th scope="col" style="width: ">SATUAN</th>
                        <th scope="col" style="width: ">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->detail as $detail)
                        <tr>
                            <th scope="col">{{ $loop->iteration }}</th>
                            <td>{{ $detail->nama_barang }}</td>
                            <td style="text-align: center">{{ $detail->jumlah }}</td>
                            <td style="text-align: center">{{ $detail->satuan }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table id="signature" style="width: 100%; margin-top: 20px">
                <tr>
                    <td scope="col" style="width: 25%; text-align: center;">
                        <p style="margin-bottom: 60px">Yang menerima,</p>
                        <div
                            style="margin: auto; width: 150px; height: 2px; border-top: 1px dashed black; border-bottom: 0.1px solid black;">
                        </div>
                    </td>
                    <td scope="col" style="width: 25%; text-align: center;">
                        <p style="margin-bottom: 60px">Hormat Kami,</p>
                        <div
                            style="margin: auto; width: 150px; height: 2px; border-top: 1px dashed black; border-bottom: 0.1px solid black;">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
