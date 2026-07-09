@extends('admin.temp.template')

@section('site-title', 'Saldo Awal Piutang')

@section('main-contents')
    <div id="message" data-msg="{{ session('add') }}"></div>
    <div class="row">
        <div class="col-lg">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Input Piutang (Per FAKTUR)</h5>
                    <div class="row">
                        <form action="{{ route('sa-piutang') }}" method="post">
                            @csrf
                            <div class="col-8">
                                <div class="row d-flex">
                                    <div class="col-6">
                                        <div class="row mb-3">
                                            <label for="kodeMember" class="col-sm-5 col-form-label">ID Anggota</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control trans-section" data-datats="ts-1"
                                                        id="kodeMember" name="kodeMember" required>
                                                    <button type="button" class="input-group-text" id="btnMember"
                                                        data-bs-toggle="modal" data-bs-target="#memberModal">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="row mb-3">
                                            <label for="noDpb" class="col-sm-5 col-form-label">No DPB</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control trans-section" data-datats="ts-1"
                                                        id="noDpb" name="noDpb">
                                                    <button type="button" class="input-group-text" id="btnNoDpb">
                                                        <i class="fas fa-key"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="row mb-3">
                                            <label for="noFaktur" class="col-sm-5 col-form-label">No Faktur</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control trans-section" data-datats="ts-1"
                                                        id="noFaktur" name="noFaktur">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="jenisMMT" class="col-sm-5 col-form-label">Jenis</label>
                                            <div class="col-sm-7">
                                                <select class="form-select" name="jenisMMT" id="jenisMMT"
                                                    aria-label="Default select example">
                                                    <option value="penjualan">Unit</option>
                                                    <option value="mmt-area">MMT Area</option>
                                                    <option value="mmt-reguler">MMT Reguler</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="tanggal" class="col-sm-5 col-form-label">Tanggal Piutang</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="date" class="form-control trans-section" data-datats="ts-1"
                                                        id="tanggal" name="tanggal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="total" class="col-sm-5 col-form-label">Total Faktur</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control trans-section" data-datats="ts-1"
                                                        id="total" name="total" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="donasi" class="col-sm-5 col-form-label">Donasi</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control trans-section" data-datats="ts-1"
                                                        id="donasi" name="donasi">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row d-flex justify-content-end mt-2">
                                    <div class="col d-flex justify-content-end">
                                        <button type="button" class="btn btn-warning btn-sm mr-2" id="batal"><i
                                                class="fas fa-times"></i> Batal</button>
                                        <button class="btn btn-info btn-sm text-light" id="slsPrintTransc"><i
                                                class="fas fa-save"></i> Selesai</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- modal data member -->
    <div class="modal fade" id="memberModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memberModalLabel">Data Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-striped table-hover table-data-member" id="tableModalMember">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Kode Anggota</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Unit</th>
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
                                        <td>{{ $m->unit }}</td>
                                        <td>{{ $m->alamat == '' ? '-' : $m->alamat }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm text-light add-item-member"
                                                data-bs-dismiss="modal" aria-label="Close"
                                                data-datakode="{{ $m->kode_member }}">
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
        $('document').ready(function() {
            $('#tableModalMember').DataTable();

            let btnModalTambahMember = () => $("button.add-item-member").on("click", function(e) {
                var data = {
                    kode: $(this).data('datakode'),
                };
                let kode = $("#kodeMember").val(data.kode);
            });
            setInterval(function() {
                btnModalTambahMember();
            }, 1000);

            // generate NO Pembelian
            $('#btnNoDpb').click(function(e) {
                axios.get(globalUrl + 'get-no-dpb/')
                    .then((response) => {
                        $('#noDpb').val(response.data.no_dpb)
                    })
                    .catch((error) => {
                        console.log(error.response)
                    })
            });
            // end

            $('#total').on('change paste keyup', function(e) {
                $(this).val(currencyIdr($(this).val(), 'Rp '));
            });

            $('#donasi').on('change paste keyup', function(e) {
                $(this).val(currencyIdr($(this).val(), 'Rp '));
            });

            let is_add = $('#message').data('msg');
            if (is_add === 'succesful') {
                Swal.fire(
                    'Data berhasil ditambahkan!',
                    'success!',
                    'success'
                ).then((result) => {})
            } else if (is_add === 'failed') {
                Swal.fire(
                    'Data gagal ditambahkan!',
                    'failed!',
                    'error'
                ).then((result) => {})
            }
        })

    </script>
@endsection
