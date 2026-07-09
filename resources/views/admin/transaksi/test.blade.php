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

    <title>Test Struk</title>
</head>

<body style="width: 100%; font-family: Arial, Helvetica, sans-serif;">

    @foreach ($data as $transaksi)
        <table id='printStruk'
            style='align-items: center; justify-content: center; font-size: 11px; font-weight: bold; border-top: 1px dashed black; border-bottom: 1px dashed black; border-spacing: 8px; width: 186px'>
            <tr>
                <td colspan='3' style='text-align: center'>
                    <img src='{{ asset('assets/img/icon/logo.png') }}' alt='AHS Asean Pasifik img' style='width: 60px'>
                </td>
            </tr>
            <tr>
                <td colspan='3' style='text-align: center'>AHS Asean Pasifik</td>
            </tr>
            <tr>
                <td colspan='3' style='text-align: center'>Tgl:
                    {{ date('d-m-Y H:i:s', strtotime($transaksi->tanggal)) }}
                    </br>
                    @if ($transaksi->member_id != 'U-00-01')
                        Unit:
                        {{ $transaksi->member->kode_member == 'U-00-01' ? '-' : $transaksi->member->unit . ' | ' . $transaksi->member->nama }}
                    @endif
                </td>
            </tr>
            @if ($transaksi->is_lunas == '1' && $transaksi->jenis_transaksi == 'penjualan')
                <tr style='margin-bottom: 20px'>
                    <td style='border-bottom: 1px solid black;'>ID Kasir:</br>{{ $transaksi->kasir->id }}</td>
                    <td colspan='2' style='border-bottom: 1px solid black; text-align: right'>No.
                        Resi:</br>{{ $transaksi->no_resi }}
                    </td>
                </tr>
                @if ($transaksi->is_lunas == '0')
                    <tr>
                        <td colspan='3' style='border-bottom: 1px dashed black; text-align: center;'>
                            PIUTANG
                        </td>
                    </tr>
                @endif
                @foreach ($transaksi->detail as $detail)
                    <tr>
                        <td>{{ $detail->nama_barang }}</td>
                        <td style='text-align: center'>
                            {{ $helper->money_format($detail->jumlah) . ' ' . $detail->satuan }}
                        </td>
                        <td class='harga-item-struk' style='text-align: right'>
                            {{ $helper->money_format($detail->harga, 'Rp ') }}</td>
                    </tr>
                @endforeach
                @if ($transaksi->diskon > 0)
                    <tr>
                        <td style='border-top: 1px solid black;'>Total</td>
                        <td colspan='2' id='totalStruk' style='border-top: 1px solid black; text-align: right'>
                            {{ $helper->money_format($total, 'Rp ') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Diskon</td>
                        <td colspan='2' style='text-align: right'>{{ $transaksi->diskon }} %</td>
                    </tr>
                @endif
                <tr>
                    @if ($transaksi->is_lunas == '1')
                        <td style='border-top: 1px solid black;'>Grand Total</td>
                    @else
                        <td style='border-top: 1px solid black;'>Total Piutang</td>
                    @endif
                    <td colspan='2' id='grandTotalStruk' style='border-top: 1px solid black; text-align: right'>
                        {{ $helper->money_format($transaksi->total, 'Rp ') }}
                    </td>
                </tr>
                @if ((int) $transaksi->donasi > 0)
                    <tr>
                        <td>Donasi</td>
                        <td colspan='2' id='donasi' style='text-align: right'>
                            {{ $helper->money_format($transaksi->donasi, 'Rp ') }}</td>
                    </tr>
                @endif
                <tr>
                    <td>Uang</td>
                    <td colspan='2' id='uangStruk' style='text-align: right'>
                        {{ $helper->money_format($transaksi->uang, 'Rp ') }}</td>
                </tr>
                @if ($transaksi->is_lunas == '1')
                    <tr>
                        <td>Kembali</td>
                        <td colspan='2' id='kembaliStruk' style='text-align: right'>
                            {{ $helper->money_format((int) $transaksi->uang - ((int) $transaksi->total + (int) $transaksi->donasi) > 0 ? (int) $transaksi->uang - ((int) $transaksi->total + (int) $transaksi->donasi) : 0, 'Rp ') }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>Sisa Piutang</td>
                        <td colspan='2' id='kembaliStruk' style='text-align: right'>
                            {{ $helper->money_format((int) $transaksi->total - (int) $transaksi->uang, 'Rp ') }}</td>
                    </tr>
                    <tr>
                        <td colspan='3' style='border-top: 1px solid black; text-align: center;'>Struk
                            PIUTANG!</br>Jangan sampai hilang!
                        </td>
                    </tr>
                @endif
            @else
                <tr>
                    <td colspan="3" style="text-align: center">
                        <h2 style="border: 1px solid black">{{ $transaksi->no_resi }}</h2>
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan='3' style='border-top: 1px solid black; text-align: center'>Terima Kasih</td>
            </tr>
            <tr>
                <td colspan='3' style='border-top: 1px solid black; text-align: center;'>
                    <div id='qrcodeStruk'></div>
                </td>
            </tr>
            <tr>
                <td colspan='3' style='text-align: center; font-size: 0.6rem;'>
                    Aplikasi Kasir &#169; {{ date('Y') }} by Beegency
                </td>
            </tr>
        </table>
    @endforeach

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
