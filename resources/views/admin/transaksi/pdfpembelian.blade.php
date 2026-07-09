<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="url-global" content="{{ config('app.url') }}">

    <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>

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

    <title>PDF Pembelian</title>
</head>

<body>
    <table id="dataMember">
        <thead>
            <tr class="head-list">
                <th colspan="2">
                    <h4>Pembelian Barang</h4>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>No Resi: {{ $transaksi->no_resi }}</td>
                <td>Tanggal: {{ date('d-m-Y H:i:s') }}</td>
            </tr>
            <tr>
                <td>Kasir: {{ $transaksi->kasir->name . ' | ' . $transaksi->kasir->id }}</td>
            </tr>
        </tbody>
    </table>
    <table id="dataTransaksi">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kode Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Total</th>
                <th scope="col">Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->detail as $detail)
                <tr class="head-list">
                    <th scope="col">{{ $loop->iteration }}</th>
                    <td>{{ $detail->kode_barang }}</td>
                    <td>{{ $detail->nama_barang }}</td>
                    <td>{{ $detail->jumlah . ' ' . $detail->satuan }}</td>
                    <td class="harga-total">{{ $detail->harga }}</td>
                    <td></td>
                </tr>
            @endforeach
            <tr class="head-list">
                <?php foreach ($transaksi->detail as $detail) {
                $total += $detail->harga;
                } ?>
                <th scope="col" colspan="4">
                    <h1>Total</h1>
                </th>
                <td class="harga-total">{{ $total }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
<script>
    function currencyIdr(angka, prefix) {
        let number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
    }

    $('.harga-total').each(function(e) {
        $(this).html(currencyIdr($(this).html(), 'Rp '));
    })

</script>

</html>
