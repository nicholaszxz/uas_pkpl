@extends('admin.temp.template')

@section('site-title', 'Daftar Barang')

@section('main-contents')
    <div class="row">
        <div class="col-sm-3">
            <h4>Daftar Jenis Barang</h4>
            <hr class="divider">
        </div>
    </div>

    <div class="row d-flex justify-content-between">
        <div class="col-md-3 border p-2">
            <form action="/store-jenis-barang" method="post" id="storeBarang">
                @csrf
                <h5 class="mt-2 mb-3"><i class="fas fa-plus"></i> Tambah Jenis Barang</h5>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-4 col-form-label">Nama :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control enter-pass" id="nama_jenis" name="nama_jenis" data-nextid="">
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-sm mt-2" id="tmbhBtn"><i class="fas fa-plus"></i>
                    Tambah</button>
            </form>
        </div>

        <div class="col-md-8 border">
            <div class="p-2">
                <div class="row">
                    <h5 class="mt-2 mb-3"><i class="fas fa-cart-plus"></i> Detail Jenis Barang</h5>
                </div>
                <div class="row mt-3 overflow-auto">
                    <table class="table table-striped table-hover" id="tableItem">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Jenis</th>
                                <th scope="col">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenis as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_jenis }}</td>
                                    <td>
                                        <button type="button" class='btn btn-warning btn-sm btn-edit-jenis'
                                            data-id="{{ $item->id }}" data-bs-toggle="modal"
                                            data-bs-target="#editJenisModal"><i class='far fa-edit'></i></button>
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
    {{-- Modal Edit Jenis Barang --}}
    <div class="modal fade" id="editJenisModal" tabindex="-1" aria-labelledby="editJenisModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJenisModalLabel">Edit Jenis Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/update-jenis-barang" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_jenis_edit" id="id_jenis_edit">
                        <div class="row mt-3">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Satuan :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nama_jenis_edit" id="nama_jenis_edit">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning" id="btnStEdit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('.btn-edit-jenis').each(function() {
                $(this).click(function(e) {
                    let id = $(this).data('id');
                    axios.get('/show-jenis-barang/' + id)
                        .then((response) => {
                            let data = response.data.data;
                            $('input#id_jenis_edit').val(data.id);
                            $('input#nama_jenis_edit').val(data.nama_jenis);
                        }).catch((error) => {
                            console.log(error.response)
                        })
                });
            });
        })

    </script>
@endsection
