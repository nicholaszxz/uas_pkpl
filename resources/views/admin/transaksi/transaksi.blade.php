@extends('admin.temp.template')

@section('site-title', 'Transaksi Penjualan')

@section('main-contents')

    <!-- daftar tab -->
    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-penjualan">
                <span>Penjualan</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-pembelian">
                <span>Pembelian</span>
            </a>
        </li> --}}
    </ul>

    <div class="tab-content">

        <!-- transaksi penjualan -->
        <div class="tab-pane tabs-animation fade show active" id="tab-content-penjualan" role="tabpanel">
            <div class="row">
                <div class="col-lg">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Data Penjualan</h5>
                            <div class="row alert-row" style="display: none">
                                <div class="alert alert-danger alert-row" data-start="true" role="alert">
                                    Data Barang <strong>Tidak</strong> Tersedia! Harap cek kembali form
                                    <strong>Transaksi</strong> di bawah!
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="row d-flex flex-row-reverse">
                                        <div class="col">
                                            <div class="row mb-3">
                                                <div class="col-sm-6">
                                                    <fieldset disabled="disabled">
                                                        <input type="text" class="form-control" id="nama" name="nama"
                                                            placeholder="Nama Barang">
                                                    </fieldset>
                                                </div>
                                                <label for="diskonItem" class="col-sm-2 col-form-label">Disc</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control pay-section"
                                                            data-dataps="ps-1" id="diskonItem" value="">
                                                        <button type="button" class="input-group-text"
                                                            id="btnDiskonItem">%</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row mb-3">
                                                <label for="inputPassword3" class="col-sm-4 col-form-label">Barcode</label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" name="kodeBarang" id="kodeBarang">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control trans-section"
                                                            data-datats="ts-1" id="barcode" name="barcode">
                                                        <button type="button" class="input-group-text"
                                                            data-bs-toggle="modal" data-bs-target="#barangModal"><i
                                                                class="fas fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row d-flex">
                                                <label for="inputPassword3" class="col-sm-3 col-form-label">Harga</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control trans-section" data-datats="ts-2"
                                                        value="" id="harga" name="harga">
                                                </div>
                                                <label for="inputPassword3" class="col-sm-2 col-form-label">Qty</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" value="" id="stok" name="stok"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row d-flex">
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control trans-section ts-3"
                                                            data-datats="ts-3" id="jumlah" name="jumlah" value="">
                                                        <button type="button" class="input-group-text"
                                                            id="btnJumlah">#</button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <fieldset disabled="disabled">
                                                        <input type="text" class="form-control" value="" id="total"
                                                            name="total">
                                                    </fieldset>
                                                </div>
                                                <div class="col-sm-2 col-form-label">
                                                    <button class="btn btn-info btn-sm text-light" id="tambah"><i
                                                            class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="scroll-area-sm">
                                            <div class="scrollbar-container ps--active-y">
                                                <table class="mb-0 table table-striped" id="tableItem">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Kode</th>
                                                            <th scope="col">Item</th>
                                                            <th scope="col">Jumlah</th>
                                                            <th scope="col">Harga</th>
                                                            <th scope="col">#</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row d-flex flex-row-reverse">
                                        <div class="col-8 d-flex justify-content-end">
                                            <h4 class="text-danger border-bottom border-danger" id="totalText">Rp 0</h4>
                                        </div>
                                    </div>
                                    <div class="row d-none flex-row-reverse mt-2">
                                        <div class="col-sm-6">
                                            <select class="form-select" aria-label="Default select example"
                                                id="jenis_transaksi" name="jenis_transaksi">
                                                <option value="penjualan" selected>General</option>
                                                <option value="pengiriman">Anggota</option>
                                            </select>
                                        </div>
                                        <label for="jenis_transaksi" class="col-sm-4 col-form-label">Tipe :</label>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="date" class="form-control pay-section" id="tanggal" value="">
                                        </div>
                                        <label for="inputPassword3" class="col-4 col-form-label">Tanggal :</label>
                                    </div>
                                    {{-- <div style="display: none"> --}}
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="hidden" name="unitMember" id="unitMember">
                                            <input type="text" class="form-control pay-section" data-dataps="ps-1"
                                                id="kodeMember" value="">
                                            <button type="button" class="input-group-text" id="btnKodeMember"
                                                data-bs-toggle="modal" data-bs-target="#memberModal"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                        <label for="" class="col-4 col-form-label">Kode Member :</label>
                                    </div>
                                    {{-- </div> --}}
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="text" class="form-control pay-section" data-dataps="ps-2"
                                                id="diskon" name="diskon">
                                            <button type="button" class="input-group-text" id="btnDiskon">%</button>
                                        </div>
                                        <label for="diskon" class="col-4 col-form-label">Diskon :</label>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="text" class="form-control pay-section" data-dataps="" id="donasi"
                                                value="">
                                        </div>
                                        <label for="donasi" class="col-4 col-form-label">Donasi :</label>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="text" class="form-control pay-section" data-dataps="ps-3"
                                                id="uangTotal" value="">
                                        </div>
                                        <label for="inputPassword3" class="col-4 col-form-label">Uang :</label>
                                    </div>
                                    <div class="row flex-row-reverse mt-2 text-alert-total" style="display: none">
                                        <div class="row mt-2 text-end">
                                            <p class="text-danger text-alert-total">Uang anda tidak cukup!</p>
                                        </div>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="text" class="form-control pay-section" data-dataps="ps-4"
                                                id="kmblTotal" value="">
                                        </div>
                                        <label for="inputPassword3" class="col-4 col-form-label">Kembalian :</label>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col position-relative form-check d-flex justify-content-end mt-2 mb-2">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id="piutangCheck">
                                                piutang
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-end mt-2">
                                        <div class="col d-flex justify-content-end">
                                            <button type="button" class="btn btn-warning btn-sm mr-2" id="batal"><i
                                                    class="fas fa-times"></i> Batal</button>
                                            <button class="btn btn-info btn-sm text-light" id="slsPrintTransc"><i
                                                    class="fas fa-save"></i> Selesai</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- transaksi pembelian -->
        {{-- @if ($level != 3)
            @include('admin.transaksi.pembelian')
        @endif --}}

    </div>

@endsection

@section('modals')
    {{-- Modal Data Barang --}}
    <div class="modal fade" id="barangModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangModalLabel">Data Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-striped table-hover table-data-barang" id="tableItems">
                            <thead>
                                <tr>
                                    <th scope="col">Barcode</th>
                                    <th scope="col">Barang</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $b)
                                    @if (count($b->satuan) > 0)
                                        <tr>
                                            <td>{{ $b->barcode }}</td>
                                            <td>{{ $b->nama }}</td>
                                            <td>{{ $helper->money_format($b->stok) . ' ' . $b->satuan[0]->nama_satuan }}
                                            </td>
                                            <td>{{ $helper->money_format($b->satuan[0]->harga_jual, 'Rp ') }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm text-light add-item"
                                                    data-bs-dismiss="modal" aria-label="Close" id="addItem[]"
                                                    data-datakode="{{ $b->kode_barang }}"
                                                    data-databarcode="{{ $b->barcode }}"
                                                    data-datanama="{{ $b->nama }}"
                                                    data-datastok="{{ $b->stok * $b->satuan[0]->rasio }}"
                                                    data-datasatuan="{{ $b->satuan[0]->nama_satuan }}"
                                                    data-datarasio="{{ $b->satuan[0]->rasio }}"
                                                    data-dataharga="{{ $b->satuan[0]->harga_jual }}"><i
                                                        class="fas fa-plus text-light"></i></button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal hapus item --}}
    <div class="modal fade" id="hapusItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="hapusItemModalLabel">Peringatan!!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hapusItem" id="hapusItem" value="">
                    <p>Anda yakin akan menghapus item ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="hapusBtnModal" data-bs-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Data Member --}}
    <div class="modal fade" id="memberModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memberModalLabel">Data Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-striped table-hover table-data-member" id="tableItemsMember">
                            <thead>
                                <tr>
                                    <th scope="col">No Anggota</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($member as $m)
                                    <tr>
                                        <td>{{ $m->no_anggota }}</td>
                                        <td>{{ $m->nama }}</td>
                                        <td>{{ $m->unit }}</td>
                                        <td>{{ $m->alamat }}</td>
                                        <td><button class="btn btn-info btn-sm text-light add-item-member"
                                                data-bs-dismiss="modal" aria-label="Close"
                                                data-datakode="{{ $m->kode_member }}"><i
                                                    class="fas fa-plus text-light"></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @yield('modal-e') --}}
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $("#tableItems").DataTable();
            $("#tableItemsMember").DataTable();
            $('.alert-row').hide();
            $('.text-alert-total').hide();
            $('button#tambah').prop('disabled', true);
            let alertCheck = $('#tambah').data('start');
            (alertCheck) ? $('#tambah').prop('disabled', true): $('#tambah').prop('disabled', false);
            $('#batal').click();

            $('div#tableItems_filter label input').on('change paste keyup', function(e) {
                btnModalTambah();
            });

            $('div#tableItems_length label select').on('change', function(e) {
                btnModalTambah();
            });

            $('.paginate_button').each(function(e) {
                $(this).on('click', function(e) {
                    btnModalTambah();
                })
            });

            $('div#tableItemsMember_length label select').on('change', function(e) {
                btnModalTambahMember();
            });

            $('div#tableItemsMember_filter label input').on('change paste keyup', function(e) {
                btnModalTambahMember();
            });

            $('div#tableItemsMember_paginate a.paginate_button').each(function(e) {
                $(this).on('click', function(e) {
                    btnModalTambahMember();
                })
            });

            // set focus
            $('.trans-section[data-datats=ts-1]').focus();
            // end

            // window press f2
            $(this).on('keydown', function(event) {
                if (event.keyCode === 113) {
                    $('.pay-section[data-dataps=1]').focus();
                }
            });
            // end

            // get data barang
            // let getBarang = () => axios.get(globalUrl + 'getall-barang/')
            //     .then((response) => {
            //         let tipe = $('#jenis_transaksi').val();
            //         $('table.table-data-barang').find('tbody').empty();
            //         let data = response.data.barang;
            //         for (let i = 0; i < data.length; i++) {
            //             let dataLoop =
            //                 "<tr><td><p>" +
            //                 data[i].kode_barang +
            //                 "</p></td><td><p>" +
            //                 (data[i].barcode == null ? '-' : data[i].barcode) +
            //                 "</p></td><td><p>" + data[i].nama +
            //                 "</p></td><td><p>" + data[i].stok + ' ' + data[i].satuan[0].nama_satuan +
            //                 "</p></td><td><p>" + currencyIdr(String((tipe == 'penjualan' ? data[i].satuan[0]
            //                     .harga_jual : data[i]
            //                     .satuan[0].harga_supl)), 'Rp ') +
            //                 ' / ' +
            //                 data[i]
            //                 .satuan[
            //                     0].nama_satuan +
            //                 "</p></td><td><button class='btn btn-info btn-sm text-light add-item' data-bs-dismiss='modal'aria-label='Close' id='addItem[]' data-datakode='" +
            //                 data[i].kode_barang + "' data-databarcode='" + data[i].barcode +
            //                 "' data-datanama='" + data[i].nama + "' data-datastok='" + data[i].stok * data[i]
            //                 .satuan[0].rasio + "' data-datasatuan='" + data[i].satuan[0].nama_satuan +
            //                 "' data-datarasio='" + data[i].satuan[0].rasio +
            //                 "' data-dataharga='" + (tipe == 'penjualan' ? data[i].satuan[0].harga_jual : data[i]
            //                     .satuan[0].harga_supl) +
            //                 "'><i class='fas fa-plus text-light'></i></button></td></tr>";
            //             $('.table-data-barang').find('tbody').append(dataLoop);
            //             btnModalTambah();
            //             $("#tableItems").DataTable();
            //         }
            //     }).catch((error) => {
            //         console.log(error);
            //     })
            // getBarang();
            // end

            // tipe
            // $('#jenis_transaksi').change(function(e) {
            //     getBarang();
            // });
            // end

            // get data member
            // let getMember = () => axios.get(globalUrl + 'getall-member/')
            //     .then((response) => {
            //         $('table.table-data-member').find('tbody').empty();
            //         let data = response.data.member;
            //         for (let i = 0; i < data.length; i++) {
            //             let dataLoop =
            //                 "<tr><td><p>" +
            //                 data[i].kode_member +
            //                 "</p></td><td><p>" +
            //                 data[i].nama +
            //                 "</p></td><td><p>" + data[i].unit +
            //                 "</p></td><td><p>" + data[i].alamat +
            //                 "</p></td><td><button class='btn btn-info btn-sm text-light add-item-member' data-bs-dismiss='modal'aria-label='Close' data-datakode='" +
            //                 data[i].kode_member + "'><i class='fas fa-plus text-light'></i></button></td></tr>";
            //             $('.table-data-member').find('tbody').append(dataLoop);
            //             btnModalTambahMember();
            //             $("#tableItemsMember").DataTable();
            //         }
            //     }).catch((error) => {
            //         console.log(error);
            //     })
            // getMember();
            // end

            // btn member
            let btnModalTambahMember = () => $("button.add-item-member").on("click", function(e) {
                var data = {
                    kode: $(this).data('datakode'),
                };
                let kode = $("#kodeMember").val(data.kode);
            });
            setInterval(function() {
                btnModalTambahMember();
            }, 1000);
            // end

            // button batal
            $('#batal').on('click', function(e) {
                $('#namaCust').val('');
                $('#unitCust').val('');
                $('#teleponCust').val('');
                $('#alamatCust').val('');
                $('#kodeBarang').val('');
                $('#barcode').val('');
                $('#nama').val('');
                $('#harga').val('');
                $('#stok').val('');
                $('#jumlah').val('');
                $('#btnJumlah').html('#');
                $('#total').val('');
                $('.itemRow').remove();
                $('#diskon').val('');
                $('#uangTotal').val('');
                $('#kmblTotal').val('');
                $('#kodeMember').val('');
                totalHarga();
                $('#barcode').focus();
                $('#slsPrintTransc').prop('disabled', true);
                $('#piutangCheck').prop('checked', false);
            });
            // end

            // loop pay section
            let paySection = $('.pay-section');
            for (let i = 0; i < paySection.length; ++i) {
                $(paySection[i]).on('keydown', function(e) {
                    if (event.keyCode === 13) {
                        let loop = $(this).data('dataps');
                        loop = loop.replace('ps-', '')
                        loop = parseInt(loop) + 1;
                        let nextID = $(".pay-section[data-dataps=ps-" + loop + "]");
                        if (nextID.length) {
                            idNum = loop;
                        } else {
                            idNum = 1;
                            let totalText = replaceCurrency($('#totalText').html());
                            if (totalText != 0)
                                $('#slsPrintTransc').click();
                        }
                        $(".pay-section[data-dataps=ps-" + idNum + "]").focus();
                    } else if (event.keyCode === 113) {
                        $('.trans-section[data-datats=ts-1]').focus();
                    }
                });
            }

            // loop focus enter
            let transSect = $('.trans-section');
            for (let i = 0; i < transSect.length; i++) {
                $(transSect[i]).on("keydown", function(event) {
                    if (event.keyCode === 13) {
                        let loop = $(this).data('datats');
                        loop = loop.replace('ts-', '');
                        loop = parseInt(loop) + 1;
                        let nextID = $(".trans-section[data-datats=ts-" + loop + "]");
                        if (nextID.length) {
                            idNum = loop;
                            $(".trans-section[data-datats=ts-" + idNum + "]").focus();
                        } else {
                            idNum = 1;
                            let kodeCheck = $('#kodeBarang').val();
                            let jumlah = Number($(this).val());
                            let stok = Number($('#stok').val());
                            let totalCheck = (jumlah > stok) ? true : false;
                            if (kodeCheck == '' || totalCheck) {
                                $('#tambah').prop('disabled', true);
                                $(".trans-section[data-datats=ts-" + transSect.length + "]").focus();
                            } else {
                                $('#tambah').click();
                                $('#tambah').prop('disabled', false);
                                $(".trans-section[data-datats=ts-" + idNum + "]").focus();
                            }
                        };
                    } else if (event.keyCode == 113) {
                        $('.pay-section[data-dataps=ps-1]').focus();
                    }
                });
            }
            // end

            // check tombol selesai
            $('#slsPrintTransc').attr('disabled', true);
            $('#uangTotal').keyup(function() {
                if ($(this).val().length != 0)
                    $('#slsPrintTransc').attr('disabled', false);
                else
                    $('#slsPrintTransc').attr('disabled', true);
            })
            // end

            // check barcode
            $('#barcode').on('change paste', function(e) {
                let barcode = $(this).val();
                axios.get(globalUrl + 'show-barang-transaksi/' + barcode)
                    .then((response) => {
                        let data = response.data.barang[0];
                        $('#kodeBarang').val(data.kode_barang);
                        $('#nama').val(data.nama);
                        $('#harga').val(currencyIdr(String(data.satuan[0].harga_jual), 'Rp '));
                        $('#stok').val(data.stok);
                        $('#jumlah').val(1);
                        $('#btnJumlah').html(data.satuan[0].nama_satuan);
                        $('#total').val(currencyIdr(String(data.satuan[0].harga_jual * 1), 'Rp '));
                        $('.alert-row').hide();
                        $('#tambah').prop('disabled', false);
                    }).catch((error) => {
                        console.log(error.response);
                        let brcd = $(this).val();
                        $('#kodeBarang').val('');
                        $('#nama').val('');
                        $('#harga').val('');
                        $('#stok').val('');
                        $('#jumlah').val('');
                        $('#total').val('');
                        $('#btnJumlah').html('#');
                        $('#tambah').prop('disabled', true);
                        if (brcd != '') {
                            $('.alert-row').show();
                        } else {
                            $('.alert-row').hide();
                            $('#tambah').prop('disabled', false);
                        }
                    })
            });
            // end

            // diskon per-item
            $('#diskonItem').on('change paste keyup', function(e) {
                let val = Number($(this).val());
                if (val < 0 || val > 20)
                    $(this).val('0');
                hitungTotal();
            });

            // check kepastian harga
            $('#harga').on('change paste keyup', function(e) {
                $(this).val(currencyIdr(String($(this).val()), 'Rp '));
                let jumlah = Number($('#jumlah').val());
                let stok = Number($('#stok').val());
                let harga = Number($(this).val().split(".").join("").split("Rp").join(""));
                hitungTotal();
            });
            // end

            // check kesediaan jumlah
            $('#jumlah').on('keyup', function(e) {
                let jumlah = Number($(this).val());
                let stok = Number($('#stok').val());
                let harga = Number($('#harga').val().split(".").join("").split("Rp").join(""));
                let total = (jumlah > stok) ? true : false;
                if (total || jumlah <= 0) {
                    jumlah = Number($(this).val());
                    stok = Number($('#stok').val());
                    hitungTotal();
                    $('.alert-row').show();
                    $('#tambah').prop('disabled', true);
                    $(this).addClass('text-danger');
                } else {
                    hitungTotal(jumlah, harga);
                    $('.alert-row').hide();
                    $('#tambah').prop('disabled', false);
                    $(this).removeClass('text-danger');
                }
            });
            // end

            // fungsi hitung total
            function hitungTotal() {
                let diskon = Number($('#diskonItem').val());
                let harga = Number(replaceCurrency($('#harga').val()));
                let jumlah = Number($('#jumlah').val());
                let total = jumlah * harga;
                if (diskon > 0)
                    total = total - (total * (diskon / 100));
                $('#total').val(currencyIdr(String(total), 'Rp '));
            }
            // end

            // isi form transaksi tombol modal tambah
            let btnModalTambah = () => $("button.add-item").on("click", function(e) {
                var data = {
                    kode: $(this).data('datakode'),
                    barcode: $(this).data('databarcode'),
                    nama: $(this).data('datanama'),
                    stok: $(this).data('datastok'),
                    harga: $(this).data('dataharga'),
                    namaSatuan: $(this).data('datasatuan'),
                };
                let kode = $("#kodeBarang").val(data.kode);
                let barcode = $("#barcode").val(data.barcode);
                let nama = $("#nama").val(data.nama);
                let stok = $("#stok").val(data.stok);
                let harga = $("#harga").val(currencyIdr(String(data.harga), 'Rp '));
                let namaSatuan = $("#btnJumlah").html(data.namaSatuan);
                let jumlah = $("#jumlah").val(1);
                let ttl = data.harga * 1;
                let total = $("#total").val(currencyIdr(String(ttl), 'Rp '));
                $('.alert-row').hide();
                $('#tambah').prop('disabled', false);
                $('#diskon').change();
            });
            setInterval(function() {
                btnModalTambah();
            }, 1000);
            // end

            // tambah row transaksi
            $("#tambah").on("click", function(e) {
                let data = {
                    kode: $("#kodeBarang").val(),
                    nama: $("#nama").val(),
                    jumlah: $("#jumlah").val(),
                    btnJumlah: $("#btnJumlah").html(),
                    total: $("#total").val(),
                };
                let numInt = $("#tableItem").find("tbody").children().length + 1;
                let childTable =
                    "<tr class='itemRow' id='itemRow[" + numInt + "]'><td class='kode-barang'>" + data
                    .kode +
                    "</td><td class='nama-barang' id='namaItm" + numInt + "'>" +
                    data
                    .nama +
                    "</td><td id='jumlahItm" + numInt + "'><span class='jumlah-barang'>" + data.jumlah +
                    "</span> <span class='satuan-barang'>" + data.btnJumlah +
                    "</td><td class='totalHrg harga-barang' id='totalItm" + numInt + "'>" + data.total +
                    "</td><td><a class='btn btn-danger btn-sm btn-hapus' data-id='itemRow[" +
                    numInt +
                    "]' data-bs-toggle='modal' data-bs-target='#hapusItemModal' data-dataid='item" +
                    numInt + "'><i class='fas fa-trash-alt'></i></a></td></tr>";
                $("#tableItem").find("tbody").append(childTable);
                totalHarga();
                hapusRow(true);
                $('#barcode').focus();
                $('#kodeBarang').val('');
                $('#barcode').val('');
                $('#nama').val('');
                $('#harga').val('');
                $('#stok').val('');
                $('#jumlah').val('');
                $('#btnJumlah').html('#');
                $('#total').val('');
                $('#diskon').change();
                console.log($('#piutangCheck').change());
            });
            // end

            // set value hapus
            function hapusRow(check = false) {
                if (check) {
                    let btnHapus = $('.btn-hapus');
                    for (let i = 0; i < btnHapus.length; i++) {
                        $(btnHapus[i]).on('click', function(event) {
                            $('#hapusItem').val($(this).data('id'));
                        });
                    }
                }
            }
            // end

            // hapus row
            $("#hapusBtnModal").on("click", function(e) {
                let itemID = $("#hapusItem").val();
                document.getElementById(itemID).remove();

                totalHarga();
                $('#diskon').change();
                $('#barcode').focus();
            });
            // end

            // hitung total harga transaksi
            function totalHarga() {
                $("#totalText").html(function() {
                    var a = 0;
                    $(".totalHrg").each(function() {
                        a += parseInt(Number($(this).html().split(".").join("").split("Rp").join(
                            "")));
                    });
                    return currencyIdr(String(a), 'Rp ');
                });
                if (Number($('#totalText').html().split(".").join("").split("Rp").join("")) == 0) {
                    $('#diskon').val('');
                    $('#uangTotal').val('');
                    $('#kmblTotal').val('');
                }
                return $("#totalText").html();
            };
            // end

            // hitung diskon
            $('#diskon').on('change paste keyup', function(e) {
                let diskon = $('#diskon').val();
                (Number(diskon) > 20) ? diskon = true: diskon = false;
                (diskon) ? $('#diskon').val(0): $('#diskon').val($('#diskon').val());
                let total = Number(totalHarga().split(".").join("").split("Rp").join(""));
                diskon = Number($('#diskon').val());
                let uang = Number($('#uangTotal').val().split(".").join("").split("Rp").join(""));
                let donasi = Number($('#donasi').val().split(".").join("").split("Rp").join(""));
                total = total - (total * (diskon / 100));
                if (total > 0) {
                    $('#totalText').html(currencyIdr(String(Math.ceil(Math.floor(total))), 'Rp '));
                }
                if (uang > 0 && piutangcheck() == '1') {
                    let kmbl = uang - (total + donasi);
                    $("#kmblTotal").val(currencyIdr(String(kmbl), 'Rp '));
                }
            });
            // end

            // donasi
            $('#donasi').on('change paste keyup', function(e) {
                $(this).val(currencyIdr(String($(this).val()), 'Rp '));
                $("#uangTotal").change();
            });
            // end

            // hitung kembalian (uang) transaksi
            $("#uangTotal").on("change paste keyup", function() {
                $(this).val(currencyIdr($(this).val(), 'Rp '));
                let uang = Number($(this).val().split(".").join("").split("Rp").join(""));
                let total = Number($("#totalText").html().split(".").join("").split("Rp").join(""));
                let donasi = Number($("#donasi").val().split(".").join("").split("Rp").join(""));
                if (piutangcheck() == '1') {
                    let kmbl = uang - (total + donasi);
                    if (kmbl < 0) {
                        $("#kmblTotal").val('');
                        $('#slsPrintTransc').prop('disabled', true);
                        $('.text-alert-total').show();
                        $(this).addClass('text-danger');
                    } else {
                        $("#kmblTotal").val(currencyIdr(String(kmbl), 'Rp '));
                        $('#slsPrintTransc').prop('disabled', false);
                        $('.text-alert-total').hide();
                        $(this).removeClass('text-danger');
                    }
                }
            });
            // end

            // proses simpan ke database
            $("#slsPrintTransc").on("click", function() {
                let idKasir = $('#idKasir').val();
                let namaMember = $('#namaCust').val();
                let kodeMember = $('#kodeMember').val();
                let unitMember = $('#unitCust').val();
                let teleponMember = $('#teleponCust').val();
                let alamatMember = $('#alamatCust').val();
                let isLunas = piutangcheck();
                let tanggal = $('#tanggal').val();
                let noResi = $("#noResi").val();
                let ttlSm = $("#totalText").html();
                let diskon = Number($("#diskon").val());
                let donasi = $("#donasi").val() == '' ? 'Rp 0' : $("#donasi").val();
                let uang = $("#uangTotal").val() == '' ? 'Rp 0' : $("#uangTotal").val();
                let kmbl = $("#kmblTotal").val() == '' ? 'Rp 0' : $("#kmblTotal").val();
                let row = $('.itemRow');
                let dataBarang = [];
                for (let i = 0; i < row.length; i++) {
                    dataBarang.push({
                        kode: $(row[i]).find('td.kode-barang').html(),
                        nama: $(row[i]).find('td.nama-barang').html(),
                        jumlah: $(row[i]).find('span.jumlah-barang').html(),
                        satuan: $(row[i]).find('span.satuan-barang').html(),
                        harga: replaceCurrency($(row[i]).find('td.harga-barang').html())
                    });
                }
                let data = {
                    tanggal: tanggal,
                    ttlSm: ttlSm,
                    isLunas: isLunas,
                    diskon: diskon,
                    donasi: donasi,
                    uang: uang,
                    kmbl: kmbl,
                    dataBarang: dataBarang
                };
                // proses ajax simpan
                let token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                axios.post(globalUrl + 'simpan-transaksi', {
                        no_resi: noResi,
                        tanggal: tanggal,
                        jenis_transaksi: $('#jenis_transaksi').val(),
                        kasir_id: idKasir,
                        nama_member: namaMember,
                        kode_member: kodeMember,
                        unit_member: unitMember,
                        telepon_member: teleponMember,
                        alamat_member: alamatMember,
                        jenis_member: 'customer',
                        total: replaceCurrency(ttlSm),
                        diskon: diskon,
                        is_lunas: isLunas,
                        donasi: replaceCurrency(donasi),
                        uang: replaceCurrency(uang),
                        is_print: piutangcheck() == '0' ? 0 : 1,
                        detail_transaksi: dataBarang
                    })
                    .then((response) => {
                        console.log(response.data);
                        data['idKasir'] = response.data.id_kasir;
                        data['noResi'] = response.data.no_resi;
                        // getMember();
                        // getBarang();
                        printStruk(data);
                        let kmblText = $('#kmblTotal').val() == '' ? '-' : $('#kmblTotal').val();
                        let textSwal = "KEMBALI : " + kmblText;
                        Swal.fire(
                            textSwal,
                            'Transaksi Sukses!',
                            'success'
                        ).then((result) => {
                            $('#batal').click();
                            location.reload();
                        })
                    })
                    .catch((error) => {
                        console.log(error.response)
                    });
                // end
            });
            // end

            // proses print strik
            function printStruk(data) {
                let total = 0;
                let printStruk;
                $(".totalHrg").each(function() {
                    total += parseInt(Number(replaceCurrency($(this).html())));
                });
                if (piutangcheck() == '0') {
                    printStruk = window.open(globalUrl + 'test-struk/' + data.noResi);
                } else {
                    printStruk = window.open(globalUrl + 'test-struk/' + data.noResi + '/' + total + '/' +
                        replaceCurrency(data
                            .uang) + '/' + replaceCurrency(data.kmbl));
                }
                let tmout = setTimeout(function() {
                    printStruk.close()
                }, 3000);
            }
            // end

            // piutang checkbox
            $('#piutangCheck').on('change', function() {
                piutangcheck();
            });

            function piutangcheck() {
                let piutang;
                if ($('#piutangCheck').is(':checked')) {
                    piutang = '0';
                    $('#slsPrintTransc').prop('disabled', false);
                } else {
                    piutang = '1';
                }
                return piutang;
            }

            $('#piutangCheck').on('change', function() {
                if ($('#piutangCheck').is(':checked')) {
                    $('#slsPrintTransc').prop('disabled', false);
                    $('.text-alert-total').hide();
                    $('#uangTotal').removeClass('text-danger');
                    $('#slsPrintTransc').prop('disabled', false);
                }
            });

        });

    </script>

    {{-- @yield('script-e') --}}
@endsection
