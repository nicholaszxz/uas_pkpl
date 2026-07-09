@extends('admin.temp.template')

@section('site-title', 'Daftar User')

@section('main-contents')
    <div class="row">
        <div class="col-sm-2">
            <h4>Daftar User</h4>
            <hr class="divider">
        </div>
    </div>

    <div class="row d-flex justify-content-between">
        <div class="col-md-3 border p-2">
            <form action="/store-user" method="post">
                <h5 class="mt-2 mb-3"><i class="fas fa-plus"></i> Tambah User</h5>
                @csrf
                <fieldset style="display: none">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Kode :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="id" name="id" value="{{ $id }}" disabled>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col">
                        <h6>
                            <small class="text-muted">Data User</small>
                        </h6>
                        <hr class="divider">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputtext3" class="col-sm-4 col-form-label">Email :</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email" placeholder="">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="name" class="col-sm-4 col-form-label">Nama :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="name" name="name" placeholder="">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="no_hp" class="col-sm-4 col-form-label">No HP :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-4 col-form-label">Password:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="password" name="password" placeholder="">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="level" class="col-sm-4 col-form-label">Role :</label>
                    <div class="col-sm-8">
                        <select class="form-select" aria-label="Default select example" id="level" name="level">
                            @foreach ($userlevel as $ul)
                                @if ($ul->id != 1)
                                    <option value="{{ $ul->id }}">{{ $ul->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-sm mt-2" id="tmbhBtn"><i class="fas fa-plus"></i>
                    Tambah</button>
            </form>
        </div>

        <div class="col-md-8 border">
            <div class="p-2">
                <div class="row">
                    <h5 class="mt-2 mb-3"><i class="fas fa-cart-plus"></i> Detail User</h5>
                </div>
                <div class="row mt-3 overflow-auto">
                    <table class="table table-striped table-hover" id="tableUser">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode</th>
                                <th scope="col">Email</th>
                                <th scope="col">Nama</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Role</th>
                                <th scope="col">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $u)
                                <tr>
                                    <th scope="col">{{ $loop->iteration }}</th>
                                    <td>{{ $u->id }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->no_hp }}</td>
                                    <td>{{ $u->userLevel->name }}</td>
                                    <td>
                                        @if ($u->level != 1)
                                            <button class="btn btn-sm btn-warning btnEdit" data-dataid="{{ $u->id }}"
                                                data-bs-toggle="modal" data-bs-target="#editModal"><i
                                                    class='fas fa-edit'></i></button>
                                            <button class="btn btn-sm btn-danger btnHapus"
                                                data-dataid="{{ $u->id }}" data-bs-toggle="modal"
                                                data-datanama="{{ $u->name }}" data-bs-target="#hapusModal"><i
                                                    class='fas fa-trash-alt'></i></button>
                                            <button class="btn btn-sm btn-info ubah-password" id="ubahPassword"
                                                data-dataid="{{ $u->id }}" data-datanama="{{ $u->name }}"
                                                data-bs-toggle="modal" data-bs-target="#passwordModal"><i
                                                    class="fas fa-key text-white"></i></button>
                                        @endif
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
    {{-- Modal Edit User --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/update-user" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id_edit" id="id_edit">
                        <div class="row mt-3">
                            <label for="email_modal" class="col-sm-4 col-form-label">E-Mail :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email_modal" id="email_modal">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label for="name_modal" class="col-sm-4 col-form-label">Nama :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name_modal" id="name_modal">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label for="no_hp_modal" class="col-sm-4 col-form-label">No HP :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="no_hp_modal" id="no_hp_modal">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label for="level_modal" class="col-sm-4 col-form-label">Nama :</label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example" id="level_modal"
                                    name="level_modal">
                                    @foreach ($userlevel as $ul)
                                        @if ($ul->id != 1)
                                            <option value="{{ $ul->id }}">{{ $ul->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
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

    {{-- Modal Hapus User --}}
    <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="hapusModalLabel">Hapus User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_hapus" id="idHapus">
                    <h6>Apa anda yakin akan menghapus <strong><span id="nama_member_edit"></span></strong>?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btnModalHapus" data-bs-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Re:Password --}}
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="passwordModalLabel">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/repassword-user" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id_password" id="idPassword">
                        <div class="row mt-3">
                            <label for="new_password" class="col-sm-4 col-form-label">Password :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="new_password" id="new_password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" id="btnPassword">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $("#tableUser").DataTable();

            const fEdit = () => {
                let btnEdit = $('.btnEdit');
                for (let i = 0; i < btnEdit.length; i++) {
                    $(btnEdit[i]).on('click', function(e) {
                        let kode = $(this).data('dataid');
                        let token = document.head.querySelector('meta[name="csrf-token"]');
                        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                        axios.get('/show-user/' + kode)
                            .then((response) => {
                                let user = response.data.user[0];
                                $('#id_edit').val(user.id);
                                $('#email_modal').val(user.email);
                                $('#name_modal').val(user.name);
                                $('#no_hp_modal').val(user.no_hp);
                                $('#no_hp_modal').val(user.no_hp);
                                $('#level_modal').val(user.level);
                            }).catch((error) => {
                                console.log(error.response.data)
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
                        $('#idHapus').val(kode);
                    });
                }
            }
            setInterval(function() {
                fHapus();
            }, 1000);

            $('#btnModalHapus').on('click', function(e) {
                let kode = $('#idHapus').val();
                let token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                axios.delete('/delete-user/' + kode)
                    .then((response) => {
                        location.replace('/daftar-user');
                    }).catch((error) => {
                        console.log(error.response.data)
                    })
            });

            let ubahPassword = $('.ubah-password');
            for (let i = 0; i < ubahPassword.length; i++) {
                $(ubahPassword[i]).on('click', function(e) {
                    let idPassword = $(this).data('dataid');
                    $('#idPassword').val(idPassword);
                });
            }

        });

    </script>
@endsection
