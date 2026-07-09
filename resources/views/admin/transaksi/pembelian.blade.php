@extends('admin.temp.template')

@section('site-title', 'Transaksi Pembelian')

@section('main-contents')

    <!-- daftar tab -->
    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-pembelian">
                <span>Pembelian</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane tabs-animation fade show active" id="tab-content-pembelian" role="tabpanel">
            <div class="row">
                <div class="col-lg">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Data Pembelian</h5>
                            <div class="row alert-row-pembelian" style="display: none">
                                <div class="alert alert-danger" data-start="true" role="alert">
                                    Data Barang <strong>Tidak</strong> Tersedia! Harap cek kembali form
                                    <strong>Transaksi</strong> di bawah! <span>Abaikan jika ingin mendaftarkan
                                        <strong>Barang
                                            baru</strong></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="row alert-success-pembelian" style="display: none">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            Data Pembelian <strong>Berhasil</strong> disimpan.
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-2">
                                                    <div class="position-relative form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="isBarangBaru">
                                                            Barang Baru
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-floating">
                                                        <input type="hidden" name="kodeBarangPembelian"
                                                            id="kodeBarangPembelian">
                                                        <input type="text" class="form-control" id="barcodePembelian"
                                                            placeholder="0,000.eg" autofocus>
                                                        <label for="barcodePembelian">Barcode</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="namaBarangPembelian"
                                                            placeholder="0,000.eg" autofocus>
                                                        <label for="namaBarangPembelian">Nama Barang</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="hargaPembelian"
                                                            placeholder="0,000.eg" autofocus>
                                                        <label for="hargaPembelian">Harga Beli</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex align-items-center mt-3">
                                                <div class="col-3">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="jumlahPembelian"
                                                            placeholder="0,000.eg" autofocus>
                                                        <label for="jumlahPembelian">Qty</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="namaSatuanPembelian"
                                                            placeholder="0,000.eg" autofocus>
                                                        <label for="namaSatuanPembelian">Nama Satuan</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="totalPembelian"
                                                            placeholder="0,000.eg" autofocus>
                                                        <label for="totalPembelian">Total</label>
                                                    </div>
                                                </div>
                                                <div class="col-2 justify-content-center">
                                                    <button class="btn btn-warning btn-sm text-light"
                                                        id="searchBarangPembelian" data-bs-toggle='modal'
                                                        data-bs-target='#barangModalPembelian'><i
                                                            class="fas fa-search"></i></button>
                                                    <button class="btn btn-info btn-sm text-light ml-4"
                                                        id="tambahPembelian"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="scroll-area-sm">
                                            <div class="scrollbar-container ps--active-y">
                                                <table class="mb-0 table table-striped" id="tablePembelian">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Barcode</th>
                                                            <th scope="col">Item</th>
                                                            <th scope="col">Harga</th>
                                                            <th scope="col">Jumlah</th>
                                                            <th scope="col">Total</th>
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
                                            <h4 class="text-danger border-bottom border-danger" id="totalTextPembelian">Rp 0
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="hidden" name="hiddenKodeSupplier" id="hiddenKodeSupplier">
                                            <input type="text" class="form-control pay-section" data-dataps="ps-1"
                                                id="kodeSupplier" value="">
                                            <button type="button" class="input-group-text" id="btnKodeSupplier"
                                                data-bs-toggle="modal" data-bs-target="#supplierModal"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                        <label for="" class="col-4 col-form-label">Kode Supplier :</label>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="date" class="form-control pay-section" id="tanggalPembelian"
                                                value="">
                                        </div>
                                        <label for="inputPassword3" class="col-4 col-form-label">Tanggal :</label>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="text" class="form-control pay-section" id="noPembelian" value="">
                                            <button type="button" class="input-group-text" id="btnNoPembelian"><i
                                                    class="fas fa-key"></i></button>
                                        </div>
                                        <label for="inputPassword3" class="col-4 col-form-label">No Pembelian :</label>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2 d-none">
                                        <div class="col position-relative form-check d-flex justify-content-end mt-2 mb-2">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id="hutangCheck"> hutang
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-end mt-2">
                                        <div class="col d-flex justify-content-end">
                                            <button type="button" id="batalPembelian" class="btn btn-warning btn-sm mr-2"><i
                                                    class="fas fa-times"></i> Batal</button>
                                            <button class="btn btn-info btn-sm text-light" id="selesaiPembelian"><i
                                                    class="fas fa-save"></i>
                                                Selesai</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modals')
    {{-- Modal Data Barang Pembelian --}}
    <div class="modal fade" id="barangModalPembelian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangModalLabelPembelian">Data Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-striped table-hover table-data-barang-pembelian-modal"
                            id="tableItemsPembelianModal">
                            <thead>
                                <tr>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Barcode</th>
                                    <th scope="col">Barang</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Harga Beli</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $b)
                                    @if (count($b->satuan) > 0)
                                        <tr>
                                            <td>
                                                <p>{{ $b->kode_barang }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $b->barcode }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $b->nama }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $helper->money_format($b->stok * $b->satuan[0]->rasio) . ' / ' . $b->satuan[0]->nama_satuan }}
                                                </p>
                                            </td>
                                            <td>
                                                <p>{{ $helper->money_format($b->satuan[0]->harga_beli, 'Rp ') }}</p>
                                            </td>
                                            <td>
                                                <button class='btn btn-info btn-sm text-light add-item-pembelian-modal'
                                                    data-bs-dismiss='modal' aria-label='Close' id='addItemPembelianModal[]'
                                                    data-datakode='{{ $b->kode_barang }}'
                                                    data-databarcode='{{ $b->barcode }}'
                                                    data-datanama='{{ $b->nama }}'
                                                    data-datastok='{{ $b->stok * $b->satuan[0]->rasio }}'
                                                    data-datasatuan='{{ $b->satuan[0]->nama_satuan }}'
                                                    data-datarasio='{{ $b->satuan[0]->rasio }}'
                                                    data-datahargabeli='{{ $b->satuan[0]->harga_beli }}'>
                                                    <i class='fas fa-plus text-light'></i>
                                                </button>
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

    {{-- Modal hapus item Pembelian --}}
    <div class="modal fade" id="hapusItemPembelianModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="hapusItemModalLabel">Peringatan!!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hapusItemPembelian" id="hapusItemPembelian" value="">
                    <p>Anda yakin akan menghapus item ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="hapusBtnPembelianModal"
                        data-bs-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Data Supplier --}}
    <div class="modal fade" id="supplierModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">Data Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-striped table-hover table-data-supplier" id="tableItemsSupplier">
                            <thead>
                                <tr>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($member as $sup)
                                    <tr>
                                        <td>
                                            <p>{{ $sup->kode_member }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $sup->nama }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $sup->alamat }}</p>
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm text-light add-item-supplier"
                                                data-bs-dismiss="modal" aria-label="Close"
                                                data-datakode="{{ $sup->kode_member }}">
                                                <i class="fas fa-plus text-light"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $("#tableItemsSupplier").DataTable();
            $("#tableItemsPembelianModal").DataTable();

            // get supplier
            // let getSupplier = () => {
            //     axios.get(globalUrl + 'getall-supplier/')
            //         .then((response) => {
            //             console.log(response.data);
            //             $('table.table-data-supplier').find('tbody').empty();
            //             let data = response.data.member;
            //             console.table(data);
            //             for (let i = 0; i < data.length; i++) {
            //                 let dataLoop =
            //                     "<tr><td><p>" +
            //                     data[i].kode_member +
            //                     "</p></td><td><p>" +
            //                     data[i].nama +
            //                     "</p></td><td><p>" + data[i].alamat +
            //                     "</p></td><td><button class='btn btn-info btn-sm text-light add-item-supplier' data-bs-dismiss='modal'aria-label='Close' data-datakode='" +
            //                     data[i].kode_member +
            //                     "'><i class='fas fa-plus text-light'></i></button></td></tr>";
            //                 $('.table-data-supplier').find('tbody').append(dataLoop);
            //                 btnModalTambahSupplier();
            //             }
            //         })
            //         .catch((error) => {
            //             console.log(error.response)
            //         })
            // };
            // getSupplier();
            // end

            // btn member
            let btnModalTambahSupplier = () => $("button.add-item-supplier").on("click", function(e) {
                var data = {
                    kode: $(this).data('datakode'),
                };
                let kode = $("#kodeSupplier").val(data.kode);
            });
            setInterval(function() {
                btnModalTambahSupplier();
            }, 1000)
            // end

            // get data barang
            // let getPembelianBarang = () => axios.get(globalUrl + 'getall-barang/')
            //     .then((response) => {
            //         $('table.table-data-barang-pembelian-modal').find('tbody').empty();
            //         let data = response.data.barang;
            //         for (let i = 0; i < data.length; i++) {
            //             let dataLoop =
            //                 "<tr><td><p>" +
            //                 data[i].kode_barang +
            //                 "</p></td><td><p>" +
            //                 (data[i].barcode == null ? '-' : data[i].barcode) +
            //                 "</p></td><td><p>" + data[i].nama +
            //                 "</p></td><td><p>" + data[i].stok + ' ' + data[i].satuan[0].nama_satuan +
            //                 "</p></td><td><p>" + currencyIdr(String(data[i].satuan[0].harga_beli), 'Rp ') +
            //                 ' / ' +
            //                 data[i]
            //                 .satuan[
            //                     0].nama_satuan +
            //                 "</p></td><td><button class='btn btn-info btn-sm text-light add-item-pembelian-modal' data-bs-dismiss='modal'aria-label='Close' id='addItemPembelianModal[]' data-datakode='" +
            //                 data[i].kode_barang + "' data-databarcode='" + data[i].barcode +
            //                 "' data-datanama='" + data[i].nama + "' data-datastok='" + data[i].stok * data[
            //                     i]
            //                 .satuan[0].rasio + "' data-datasatuan='" + data[i].satuan[0].nama_satuan +
            //                 "' data-datarasio='" + data[i].satuan[0].rasio +
            //                 "' data-datahargabeli='" + data[i].satuan[0].harga_beli +
            //                 "'><i class='fas fa-plus text-light'></i></button></td></tr>";
            //             $('.table-data-barang-pembelian-modal').find('tbody').append(dataLoop);
            //             btnModalTambahPembelian();
            //             $("#tableItemsPembelianModal").DataTable();
            //         }
            //     }).catch((error) => {
            //         console.log(error);
            //     })
            // setInterval(function() {
            //     getPembelianBarang();
            // }, 1000)
            // end

            // isi form transaksi tombol modal tambah
            let btnModalTambahPembelian = () => $("button.add-item-pembelian-modal").on("click", function(e) {
                var data = {
                    kode_barang: $(this).data('datakode'),
                    barcode: $(this).data('databarcode'),
                    nama: $(this).data('datanama'),
                    stok: $(this).data('datastok'),
                    harga_beli: $(this).data('datahargabeli'),
                    namaSatuan: $(this).data('datasatuan'),
                };
                $('#kodeBarangPembelian').val(data.kode_barang);
                $('#barcodePembelian').val(data.barcode);
                $('#namaBarangPembelian').val(data.nama);
                $('#hargaPembelian').val(currencyIdr(String(data.harga_beli), 'Rp '));
                $('#namaSatuanPembelian').val(data.namaSatuan);
                $('.alert-row-pembelian').hide();
            });
            setInterval(function() {
                btnModalTambahPembelian();
            }, 1000)
            // end

            // check barang baru
            function barangBaru() {
                let barangBaru;
                if ($('#isBarangBaru').is(':checked')) {
                    barangBaru = 'true';
                } else {
                    barangBaru = 'false';
                }
                return barangBaru;
            };

            // check barcode
            $('#barcodePembelian').on('change paste keyup', function(e) {
                let barcode = $(this).val();
                axios.get(globalUrl + 'show-barang-transaksi/' + barcode)
                    .then((response) => {
                        let data = response.data.barang[0];
                        console.log(data);
                        $('#kodeBarangPembelian').val(data.kode_barang);
                        $('#namaBarangPembelian').val(data.nama);
                        $('#hargaPembelian').val(currencyIdr(String(data.satuan[0].harga_beli),
                            'Rp '));
                        $('#namaSatuanPembelian').val(data.satuan[0].nama_satuan);
                        $('.alert-row-pembelian').hide();
                    }).catch((error) => {
                        console.log(error.response);
                        $('#kodeBarangPembelian').val('');
                        $('#namaBarangPembelian').val('');
                        $('#hargaPembelian').val('');
                        $('#namaSatuanPembelian').val('');
                        $('.alert-row-pembelian').show();
                        if (barcode == '') $('.alert-row-pembelian').hide();
                    })
            });
            // end

            // input qty(jumlah)
            $('#jumlahPembelian').on('change paste keyup', function(e) {
                let jml = $(this).val();
                let harga = $('#hargaPembelian').val();
                hitungTotalPembelian(jml, replaceCurrency(harga));
            })

            // input harga
            $('#hargaPembelian').on('change paste keyup', function(e) {
                let harga = $(this).val();
                let jml = $('#jumlahPembelian').val();
                $(this).val(currencyIdr($(this).val(), 'Rp '));
                hitungTotalPembelian(jml, replaceCurrency(harga));
            })

            // input total
            $('#totalPembelian').on('change paste keyup', function(e) {
                $(this).val(currencyIdr($(this).val(), 'Rp '));
            })

            // fungsi hitung total Pembelian
            function hitungTotalPembelian(a, b) {
                let total = a * b;
                $('#totalPembelian').val(currencyIdr(String(total), 'Rp '));
            }
            // end

            // tambah row Pembelian
            $('#tambahPembelian').on('click', function(e) {
                let data = {
                    kodeBarang: $('#kodeBarangPembelian').val(),
                    barcode: $('#barcodePembelian').val(),
                    namaBarang: $('#namaBarangPembelian').val(),
                    harga_beli: $('#hargaPembelian').val(),
                    jumlah: $('#jumlahPembelian').val(),
                    namaSatuan: $('#namaSatuanPembelian').val(),
                    total: $('#totalPembelian').val(),
                    isBarangBaru: barangBaru(),
                };
                console.log(data);
                let numInt = $("#tablePembelian").find("tbody").children().length + 1;
                let childTable =
                    "<tr class='itemRowPembelian' id='itemPembelianRow[" + numInt +
                    "]'><td class='barang-baru-pembelian' style='display: none'>" +
                    data.isBarangBaru +
                    "</td><td class='kode-barang-pembelian' style='display: none'>" +
                    data.kodeBarang + "</td><td class='barcode-barang-pembelian'>" +
                    data
                    .barcode +
                    "</td><td class='nama-barang-pembelian' id='namaItm" + numInt + "'>" +
                    data
                    .namaBarang +
                    "</td><td class='harga-barang-pembelian' id='hargaItm" + numInt + "'>" +
                    data
                    .harga_beli +
                    "</td><td id='jumlahItm" + numInt + "'><span class='jumlah-barang-pembelian'>" +
                    data
                    .jumlah +
                    "</span> <span class='satuan-barang-pembelian'>" + data.namaSatuan +
                    "</span></td><td class='totalHrgPembelian total-barang-pembelian' id='totalItm" +
                    numInt + "'>" +
                    data
                    .total +
                    "</td><td><a class='btn btn-danger btn-sm btn-hapus-pembelian' data-id='itemPembelianRow[" +
                    numInt +
                    "]' data-bs-toggle='modal' data-bs-target='#hapusItemPembelianModal' data-dataid='item" +
                    numInt + "'><i class='fas fa-trash-alt'></i></a></td></tr>";
                $("#tablePembelian").find("tbody").append(childTable);
                hapusRowPembelian(true);
                totalHargaPembelian();
                $('.alert-row-pembelian').hide();
                $('#isBarangBaru').prop('checked', false);
                $('#kodeBarangPembelian').val('');
                $('#barcodePembelian').focus();
                $('#barcodePembelian').val('');
                $('#namaBarangPembelian').val('');
                $('#hargaPembelian').val('');
                $('#jumlahPembelian').val('');
                $('#namaSatuanPembelian').val('');
                $('#totalPembelian').val('');
            })

            // set value hapus
            function hapusRowPembelian(check = false) {
                if (check) {
                    let btnHapus = $('.btn-hapus-pembelian');
                    for (let i = 0; i < btnHapus.length; i++) {
                        $(btnHapus[i]).on('click', function(event) {
                            $('#hapusItemPembelian').val($(this).data('id'));
                        });
                    }
                }
            }
            // end

            // hapus row
            $("#hapusBtnPembelianModal").on("click", function(e) {
                let itemID = $("#hapusItemPembelian").val();
                document.getElementById(itemID).remove();
                totalHargaPembelian();
            });
            // end

            // hitung total harga transaksi
            function totalHargaPembelian() {
                $("#totalTextPembelian").html(function() {
                    var a = 0;
                    $(".totalHrgPembelian").each(function() {
                        a += parseInt(Number(replaceCurrency($(this).html())));
                    });
                    return currencyIdr(String(a), 'Rp ');
                });
                if (Number(replaceCurrency($('#totalTextPembelian').html())) == 0) {

                }
                return $("#totalTextPembelian").html();
            };
            // end

            // generate NO Pembelian
            $('#btnNoPembelian').click(function(e) {
                axios.get(globalUrl + 'get-no-dpb/')
                    .then((response) => {
                        $('#noPembelian').val(response.data.no_dpb)
                    })
                    .catch((error) => {
                        console.log(error.response)
                    })
            });
            // end

            // tombol batal pembelian
            $('#batalPembelian').on('click', function() {
                $('.alert-row-pembelian').hide();
                $('#isBarangBaru').prop('checked', false);
                $('#kodeBarangPembelian').val('');
                $('#barcodePembelian').focus();
                $('#barcodePembelian').val('');
                $('#namaBarangPembelian').val('');
                $('#hargaPembelian').val('');
                $('#jumlahPembelian').val('');
                $('#namaSatuanPembelian').val('');
                $('#totalPembelian').val('');
                $('.itemRowPembelian').remove();
                $('#noPembelian').val('');
                $('#tanggalPembelian').val('');
                $('#kodeSupplier').val('');
                $('#hutangCheck').prop('checked', false);
                totalHargaPembelian();
            });
            // end

            // tombol selesai pembelian
            $('#selesaiPembelian').on('click', function() {
                let totalPembelian = $('#totalTextPembelian').html();
                let row = $('.itemRowPembelian');
                let dataBarangPembelian = [];
                let kodeSupplier = $('#kodeSupplier').val();
                let noDpb = $('#btnNoPembelian').val();

                let d = new Date();
                let month = d.getMonth() + 1;
                let day = d.getDate();
                let outputDate = (day < 10 ? '0' : '') + day + '-' +
                    (month < 10 ? '0' : '') + month + '-' +
                    d.getFullYear();

                for (let i = 0; i < row.length; i++) {
                    dataBarangPembelian.push({
                        baru: $(row[i]).find('td.barang-baru-pembelian').html(),
                        kode: $(row[i]).find('td.kode-barang-pembelian').html(),
                        barcode: $(row[i]).find('td.barcode-barang-pembelian').html(),
                        nama: $(row[i]).find('td.nama-barang-pembelian').html(),
                        jumlah: Number($(row[i]).find('span.jumlah-barang-pembelian').html()),
                        satuan: $(row[i]).find('span.satuan-barang-pembelian').html(),
                        harga: replaceCurrency($(row[i]).find('td.harga-barang-pembelian')
                            .html()),
                        total: replaceCurrency($(row[i]).find('td.total-barang-pembelian')
                            .html())
                    });
                };
                console.log(dataBarangPembelian);

                // proses ajax simpan pembelian
                let token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                axios.post(globalUrl + 'simpan-transaksi', {
                        tanggal: $('#tanggalPembelian').val(),
                        jenis_transaksi: 'pembelian',
                        kode_supplier: kodeSupplier,
                        no_dpb: noDpb,
                        total: replaceCurrency(totalPembelian),
                        is_lunas: hutangcheck(),
                        detail_transaksi: dataBarangPembelian
                    })
                    .then((response) => {
                        console.log(response);
                        pdfOut(response.data.data[0].no_resi);
                        $('.alert-success-pembelian').show();
                        $('#batalPembelian').click();
                    })
                    .catch((error) => {
                        console.log(error.response)
                    });
                // end

            });
            // end

            function pdfOut(resi) {
                window.open(globalUrl + 'pdf-pembelian/' + resi);
            }

            function hutangcheck() {
                let hutang;
                if ($('#hutangCheck').is(':checked')) {
                    hutang = '0';
                } else {
                    hutang = '1';
                }
                return hutang;
            }

        })

    </script>
@endsection
