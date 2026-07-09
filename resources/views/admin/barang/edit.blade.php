@extends('admin.temp.template')

@section('site-title', 'Show Barang')

@section('main-contents')
    <div class="row">
        <div class="col-sm-2">
            <h4>Rincian Barang</h4>
            <hr class="divider">
        </div>
    </div>

    <div class="row d-flex justify-content-between">
        <div class="col-md-3 border p-2">
            <h5 class="mt-2 mb-3">
                <i class='fas fa-edit'></i> Edit Barang
                <a href="{{ route('barang') }}" class="btn btn-sm btn-warning ml-3"><i class='fas fa-backward'></i>
                    Kembali</a>
            </h5>
            <fieldset disabled="disabled">
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Kode :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="noResi" value="{{ $barang[0]->kode_barang }}">
                    </div>
                </div>
            </fieldset>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Barcode :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control enter-pass" id="barcode" data-nextid="sc-1"
                        value="{{ $barang[0]->barcode }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h6>
                        <small class="text-muted">Data Barang</small>
                    </h6>
                    <hr class="divider">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Nama :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control enter-pass" id="namaBrg" name="namaBrg" data-nextid="sc-2"
                        value="{{ $barang[0]->nama }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="jenis" class="col-sm-4 col-form-label">Jenis Barang :</label>
                <div class="col-sm-8">
                    <select class="form-select enter-pass" id="id_jenis" name="id_jenis" data-nextid="sc-2">
                        @foreach ($jenis as $item)
                            <option value="{{ $item->id }}" {{ $barang[0]->id_jenis == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputtext3" class="col-sm-4 col-form-label">Stok :</label>
                <div class="col-sm-8">
                    <input type="text" aria-label="First name" class="form-control enter-pass" id="jumlahBrg"
                        name="jumlahBrg" data-nextid="sc-3" value="{{ $barang[0]->stok * $barang[0]->satuan[0]->rasio }}">
                </div>
            </div>
            <button type="button" class="btn btn-warning btn-sm mt-2" id="tmbhBtn"><i class='fas fa-edit'></i>
                Edit</button>
            {{-- <button class="btn btn-sm btn-danger btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#hapusBarangModal"><i
                    class='fas fa-trash-alt'></i> Hapus</button> --}}
        </div>

        <div class="col-md-8 border">
            <div class="p-2">
                <div class="row">
                    <h5 class="mt-2 mb-3"><i class="fas fa-cart-plus"></i> Detail Satuan
                        {{-- <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"><i
                                class="fas fa-plus"></i> Tambah Satuan</button> --}}
                    </h5>
                </div>
                <div class="row mt-3 overflow-auto">
                    <table class="table table-striped table-hover" id="tableItem">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Satuan</th>
                                <th scope="col">Rasio</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Harga Beli</th>
                                <th scope="col">Harga Jual</th>
                                <th scope="col">Harga Spl</th>
                                <th scope="col">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang[0]->satuan as $sat)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $sat->nama_satuan }}</td>
                                    <td>{{ $sat->rasio }}</td>
                                    <td>{{ $barang[0]->stok * $sat->rasio . ' ' . $sat->nama_satuan }}</td>
                                    <td class="harga-beli-barang">{{ $sat->harga_beli }}</td>
                                    <td class="harga-jual-barang">{{ $sat->harga_jual }}</td>
                                    <td class="harga-supl-barang">{{ $sat->harga_supl }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnEditSatuan"
                                            data-dataid="{{ $sat->id }}" data-bs-toggle="modal"
                                            data-bs-target="#editModal"><i class='fas fa-edit'></i></button>
                                        {{-- <button class="btn btn-sm btn-danger btnHapusSatuan"
                                            data-dataid="{{ $sat->id }}" data-bs-toggle="modal"
                                            data-bs-target="#hapusModal"><i class='fas fa-trash-alt'></i></button> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    {{-- Modal --}}
    {{-- Modal Hapus Barang --}}
    <div class="modal fade" id="hapusBarangModal" tabindex="-1" aria-labelledby="hapusBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="hapusBarangModalLabel">Hapus Satuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_hapus_barang" id="idHapusBarang" value="{{ $barang[0]->kode_barang }}">
                    <h6>Apa anda yakin akan menghapus <strong>{{ $barang[0]->nama }}</strong>?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btnModalHapus">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Satuan --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Satuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kode_barang" id="kodeBarang" value="{{ $barang[0]->kode_barang }}">
                    <div class="row mt-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Satuan :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_satuan" id="namaSatuan">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Rasio :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="rasio" id="rasio">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Harga Beli:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="harga" id="hargaBeli">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Harga Jual:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="harga" id="hargaJual">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Harga Spl:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="harga" id="hargaSupl">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnStTmbh">Kirim</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Satuan --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Satuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_edit" id="idEdit">
                    <input type="hidden" name="kode_barang_edit" id="kodeBarangEdit"
                        value="{{ $barang[0]->kode_barang }}">
                    <div class="row mt-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Satuan :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_satuan_edit" id="namaSatuanEdit">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Rasio :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="rasio_edit" id="rasioEdit">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Harga Beli :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="harga_edit" id="hargaBeliEdit">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Harga Jual :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="harga_edit" id="hargaJualEdit">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Harga Spl :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="harga_edit" id="hargaSuplEdit">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id="btnStEdit">Kirim</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Hapus Satuan --}}
    <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="hapusModalLabel">Hapus Satuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_hapus" id="idHapus">
                    <h6>Apa anda yakin akan menghapus?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btnStHapus">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(".enter-pass[data-nextid=sc-1]").focus();
        $(document).ready(function() {
            let hargaBeliBrg = $(".harga-beli-barang");
            for (let i = 0; i < hargaBeliBrg.length; i++) {
                let valThis = $(hargaBeliBrg[i]).html();
                $(hargaBeliBrg[i]).html(currencyIdr(valThis, 'Rp '));
            }

            let hargaJualBrg = $(".harga-jual-barang");
            for (let i = 0; i < hargaJualBrg.length; i++) {
                let valThis = $(hargaJualBrg[i]).html();
                $(hargaJualBrg[i]).html(currencyIdr(valThis, 'Rp '));
            }

            let hargaSuplBrg = $(".harga-supl-barang");
            for (let i = 0; i < hargaSuplBrg.length; i++) {
                let valThis = $(hargaSuplBrg[i]).html();
                $(hargaSuplBrg[i]).html(currencyIdr(valThis, 'Rp '));
            }

            $("#hargaBeli").on("change paste keyup", function(e) {
                let valThis = $(this).val();
                $(this).val(currencyIdr(valThis, 'Rp '));
            });

            $("#hargaJual").on("change paste keyup", function(e) {
                let valThis = $(this).val();
                $(this).val(currencyIdr(valThis, 'Rp '));
            });

            $("#hargaSupl").on("change paste keyup", function(e) {
                let valThis = $(this).val();
                $(this).val(currencyIdr(valThis, 'Rp '));
            });

            $("#hargaBeliEdit").on("change paste keyup", function(e) {
                let valThis = $(this).val();
                $(this).val(currencyIdr(valThis, 'Rp '));
            });

            $("#hargaJualEdit").on("change paste keyup", function(e) {
                let valThis = $(this).val();
                $(this).val(currencyIdr(valThis, 'Rp '));
            });

            $("#hargaSuplEdit").on("change paste keyup", function(e) {
                let valThis = $(this).val();
                $(this).val(currencyIdr(valThis, 'Rp '));
            });

            let enterPass = $(".enter-pass");
            for (let i = 0; i < enterPass.length; i++) {
                $(enterPass[i]).on("keydown", function(event) {
                    if (event.keyCode === 13) {
                        let idNo = $(this).data("nextid");
                        idNo = idNo.replace("sc-", "");
                        idNo = parseInt(idNo) + 1;
                        let nextID = $(".enter-pass[data-nextid=sc-" + idNo + "]");
                        if (nextID.length) {
                            idNum = idNo;
                        } else {
                            idNum = 1;
                        };
                        $(".enter-pass[data-nextid=sc-" + idNum + "]").focus();
                    }
                });
            };

            $('#tmbhBtn').on('click', function(e) {
                let kodeBarang = $('#noResi').val();
                let barcode = ($('#barcode').val() == '-') ? '' : $('#barcode').val();
                let namaBrg = $('#namaBrg').val();
                let jumlahBrg = $('#jumlahBrg').val();
                let jenis = $('#id_jenis').val();
                let token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                axios.post('/update-barang', {
                        kode_barang: kodeBarang,
                        barcode: barcode,
                        nama: namaBrg,
                        id_jenis: jenis,
                        stok: Number(jumlahBrg)
                    })
                    .then((response) => {
                        location.reload();
                    }).catch((error) => {
                        console.log(error.response.data)
                    })
            });

            $('#btnModalHapus').on('click', function(e) {
                let kode = $('#idHapusBarang').val();
                let token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                axios.delete('/delete-barang/' + kode)
                    .then((response) => {
                        location.replace('/daftar-barang');
                    }).catch((error) => {
                        console.log(error.response.data)
                    })
            });

            $('#btnStTmbh').on('click', function(e) {
                let kodeBarang = $('#kodeBarang').val();
                let namaSatuan = $('#namaSatuan').val();
                let rasio = $('#rasio').val();
                let hargaBeli = $('#hargaBeli').val();
                let hargaJual = $('#hargaJual').val();
                let token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                axios.post('/store-satuan', {
                        kode_barang: kodeBarang,
                        nama_satuan: namaSatuan,
                        rasio: parseFloat(rasio),
                        harga_beli: Number(harga.split(".").join("").split("Rp").join("")),
                        harga_jual: Number(harga.split(".").join("").split("Rp").join("")),
                    })
                    .then((response) => {
                        location.reload();
                    }).catch((error) => {
                        console.log(error.response.data)
                    })
            });

            $('.btnEditSatuan').on('click', function(e) {
                let id = $(this).data('dataid');
                axios.get('/show-satuan/' + id)
                    .then((response) => {
                        console.log(response.data.data);
                        let data = response.data.data;
                        $('#idEdit').val(data.id);
                        $('#namaSatuanEdit').val(data.nama_satuan);
                        $('#rasioEdit').val(data.rasio);
                        $('#hargaBeliEdit').val(currencyIdr(String(data.harga_beli), 'Rp '));
                        $('#hargaJualEdit').val(currencyIdr(String(data.harga_jual), 'Rp '));
                        $('#hargaSuplEdit').val(currencyIdr(String(data.harga_supl), 'Rp '));
                    }).catch((error) => {
                        console.log(error)
                    })
            });

            $('#btnStEdit').on('click', function(e) {
                let id = $('#idEdit').val();
                let namaSatuan = $('#namaSatuanEdit').val();
                let rasio = $('#rasioEdit').val();
                let hargaBeli = $('#hargaBeliEdit').val();
                let hargaJual = $('#hargaJualEdit').val();
                let hargaSupl = $('#hargaSuplEdit').val();
                let token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                axios.post('/update-satuan', {
                        id: id,
                        kode_barang: $('#kodeBarangEdit').val(),
                        nama_satuan: namaSatuan,
                        rasio: parseFloat(rasio),
                        harga_beli: Number(hargaBeli.split(".").join("").split("Rp").join("")),
                        harga_jual: Number(hargaJual.split(".").join("").split("Rp").join("")),
                        harga_supl: Number(hargaSupl.split(".").join("").split("Rp").join("")),
                    })
                    .then((response) => {
                        location.reload();
                    }).catch((error) => {
                        console.log(error.response.data)
                    })
            });

            $('.btnHapusSatuan').on('click', function(e) {
                let id = $(this).data('dataid');
                axios.get('/show-satuan/' + id)
                    .then((response) => {
                        console.log(response.data.data);
                        let data = response.data.data;
                        $('#idHapus').val(data.id);
                    }).catch((error) => {
                        console.log(error)
                    })
            });

            $('#btnStHapus').on('click', function(e) {
                let id = $('#idHapus').val();
                let token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                axios.delete('/delete-satuan/' + id)
                    .then((response) => {
                        location.reload();
                    }).catch((error) => {
                        console.log(error.response.data)
                    })
            });
        });

    </script>
@endsection
