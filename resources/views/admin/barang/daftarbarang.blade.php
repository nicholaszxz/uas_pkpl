@extends('admin.temp.template')

@section('site-title', 'Daftar Barang')

@section('main-contents')
    <div class="row">
        <div class="col-sm-2">
            <h4>Daftar Barang</h4>
        </div>
        <div class="col-sm-2">
            <a href="/stok" target="_blank"><button type="button" class="btn btn-success">Laporan Stock Opname</button></a>
        </div>
        <hr class="divider">
    </div>

    <div class="row d-flex justify-content-between">
        <div class="col-md-3 border p-2">
            <form action="/store-barang" method="post" id="storeBarang">
                @csrf
                <h5 class="mt-2 mb-3"><i class="fas fa-plus"></i> Tambah Barang</h5>
                <fieldset disabled="disabled" style="display: none">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Kode :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="noResi" value="{{ $date }}">
                        </div>
                    </div>
                </fieldset>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Barcode :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control enter-pass" id="barcode" name="barcode" data-nextid="sc-1">
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
                        <input type="text" class="form-control enter-pass" id="namaBrg" name="nama" data-nextid="sc-2">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jenis" class="col-sm-4 col-form-label">Jenis Barang :</label>
                    <div class="col-sm-8">
                        <select class="form-select enter-pass" id="id_jenis" name="id_jenis" data-nextid="sc-2">
                            @foreach ($jenis as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputtext3" class="col-sm-4 col-form-label">Stok :</label>
                    {{-- <div class="col-sm-8">
                    <input type="text" class="form-control" id="jumlahBrg" name="jumlahBrg" placeholder="">
                </div> --}}
                    <div class="input-group col-sm-8">
                        <input type="text" aria-label="First name" class="form-control enter-pass" id="jumlahBrg"
                            name="stok" data-nextid="sc-3" placeholder="jumlah">
                        <input type="text" class="form-control enter-pass" id="satuanBrg" name="nama_satuan"
                            data-nextid="sc-4" placeholder="satuan(kg/liter)">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputtext3" class="col-sm-4 col-form-label">Harga Beli :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control enter-pass" id="hargaBeliBrg" name="harga_beli"
                            data-nextid="sc-5">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputtext3" class="col-sm-4 col-form-label">Harga Jual :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control enter-pass" id="hargaJualBrg" name="harga_jual"
                            data-nextid="sc-6">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputtext3" class="col-sm-4 col-form-label">Harga Spl :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control enter-pass" id="hargaSuplBrg" name="harga_supl"
                            data-nextid="sc-6">
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-sm mt-2" id="tmbhBtn"><i class="fas fa-plus"></i>
                    Tambah</button>
            </form>
        </div>

        <div class="col-md-8 border">
            <div class="p-2">
                <div class="row">
                    <h5 class="mt-2 mb-3"><i class="fas fa-cart-plus"></i> Detail Barang</h5>
                </div>
                <div class="row mt-3 overflow-auto">
                    <table class="table table-striped table-hover" id="tableItem">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $item)
                                @if (count($item->satuan) > 0)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode_barang }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->stok . ' ' . $item->satuan[0]->nama_satuan }}</td>
                                        @if ($item->id_jenis < 1)
                                            <td>-</td>
                                        @endif
                                        @foreach ($jenis as $j)
                                            @if ($j->id == $item->id_jenis)
                                                <td>{{ $j->nama_jenis }}</td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <a href='show-barang/{{ $item->kode_barang }}' class='btn btn-primary btn-sm'><i
                                                    class='far fa-eye'></i></a>
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
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $(".enter-pass[data-nextid=sc-1]").focus();
            $("#tableItem").DataTable();
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

            $("#hargaBeliBrg").on("keyup", function(e) {
                let valThis = $(this).val();
                $(this).val(currencyIdr(valThis, 'Rp '));
            });

            $("#hargaJualBrg").on("keyup", function(e) {
                let valThis = $(this).val();
                $(this).val(currencyIdr(valThis, 'Rp '));
            });

            $("#hargaSuplBrg").on("keyup", function(e) {
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
                            $('#storeBrang').preventDefault();
                        } else {
                            idNum = 1;
                            $("#tmbhBtn").click();
                        };
                        $(".enter-pass[data-nextid=sc-" + idNum + "]").focus();
                    }
                });
            };
        });

    </script>
@endsection
