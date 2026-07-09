@extends('admin.temp.template')

@section('site-title', 'Daftar Supplier')

@section('main-contents')
    <div class="row">
        <div class="col-sm-3">
            <h4>Daftar Supplier</h4>
            <hr class="divider">
        </div>
    </div>

    <div class="row d-flex justify-content-between">
        <div class="col-md-3 border p-2">
            <form action="/store-member" method="post">
                @csrf
                <h5 class="mt-2 mb-3"><i class="fas fa-plus"></i> Tambah Supplier</h5>
                <div class="row">
                    <div class="col">
                        <h6>
                            <small class="text-muted">Data Supplier</small>
                        </h6>
                        <hr class="divider">
                    </div>
                </div>
                <div class="row mb-3 d-none">
                    <label for="jenis_member" class="col-sm-4 col-form-label">Tipe :</label>
                    <div class="col-sm-8">
                        <select class="form-select" aria-label="Default select example" id="jenis_member"
                            name="jenis_member">
                            <option value="supplier">Supplier</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nama" class="col-sm-4 col-form-label">Nama :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="">
                    </div>
                </div>
                <div class="row mb-3 d-none">
                    <label for="telepon" class="col-sm-4 col-form-label">No HP :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="telepon" name="telepon" placeholder="">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="alamat" class="col-sm-4 col-form-label">Alamat :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="">
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-sm mt-2" id="tmbhBtn"><i class="fas fa-plus"></i>
                    Tambah</button>
            </form>
        </div>

        <div class="col-md-8 border">
            <div class="p-2">
                <div class="row">
                    <h5 class="mt-2 mb-3"><i class="fas fa-cart-plus"></i> Detail Supplier</h5>
                </div>
                <div class="row mt-3 overflow-auto">
                    <table class="table table-striped table-hover" id="tableMember">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($member as $m)
                                <tr>
                                    <th scope="col">{{ $loop->iteration }}</th>
                                    <td>{{ $m->kode_member }}</td>
                                    <td>{{ $m->nama }}</td>
                                    <td>{{ $m->alamat }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnEdit" data-dataid="{{ $m->kode_member }}"
                                            data-bs-toggle="modal" data-bs-target="#editModal"><i
                                                class='fas fa-edit'></i></button>
                                        {{-- <button class="btn btn-sm btn-danger btnHapus" data-dataid="{{ $m->kode_member }}"
                                            data-datanama="{{ $m->no_anggota . ' - ' . $m->nama }}" data-bs-toggle="modal"
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
    {{-- Modal Edit Supplier --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/update-member" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="kode_member_edit" id="kode_member_edit">
                        <div class="row mt-3 d-none">
                            <label for="jenis_member_edit" class="col-sm-4 col-form-label">Tipe :</label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example" id="jenis_member_edit"
                                    name="jenis_member_edit">
                                    <option value="supplier">Supplier</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label for="nama_edit" class="col-sm-4 col-form-label">Nama :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nama_edit" id="nama_edit">
                            </div>
                        </div>
                        <div class="row mt-3 d-none">
                            <label for="telepon_edit" class="col-sm-4 col-form-label">No HP :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="telepon_edit" id="telepon_edit">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label for="alamat_edit" class="col-sm-4 col-form-label">Alamat :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="alamat_edit" id="alamat_edit">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning" id="btnModalEdit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Hapus Supplier --}}
    <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="hapusModalLabel">Hapus Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kode_member_hapus" id="kode_member_hapus">
                    <h6>Apa anda yakin akan menghapus <strong><span id="nama_member_edit"></span></strong>?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btnModalHapus" data-bs-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $("#tableMember").DataTable();

            const fEdit = () => {
                let btnEdit = $('.btnEdit');
                for (let i = 0; i < btnEdit.length; i++) {
                    $(btnEdit[i]).on('click', function(e) {
                        let kode = $(this).data('dataid');
                        let token = document.head.querySelector('meta[name="csrf-token"]');
                        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                        axios.get('/show-member/' + kode)
                            .then((response) => {
                                let member = response.data.member[0];
                                console.log(member);
                                $('#kode_member_edit').val(member.kode_member);
                                $('#jenis_member_edit').val(member.jenis_member);
                                $('#nama_edit').val(member.nama);
                                $('#telepon_edit').val(member.telepon);
                                $('#alamat_edit').val(member.alamat);
                            }).catch((error) => {
                                console.log(error)
                            })
                    });
                }
            }
            setInterval(function() {
                fEdit();
            }, 1000);

            const fHapus = () => {
                let btnHapus = $('.btnHapus');
                for (let i = 0; i < btnHapus.length; i++) {
                    $(btnHapus[i]).on('click', function(e) {
                        let kode = $(this).data('dataid');
                        let nama = $(this).data('datanama');
                        $('#nama_member_edit').html(nama);
                        $('#kode_member_hapus').val(kode);
                    });
                }
            }
            setInterval(function() {
                fHapus();
            }, 1000);

            $('#btnModalHapus').on('click', function(e) {
                let kode = $('#kode_member_hapus').val();
                let token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                axios.delete('/delete-member/' + kode)
                    .then((response) => {
                        location.replace('/daftar-member');
                    }).catch((error) => {
                        console.log(error)
                    })
            });
        });

    </script>
@endsection
