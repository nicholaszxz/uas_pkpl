@extends('admin.temp.template')

@section('site-title', 'Edit Transaksi')

@section('main-contents')
    <div id="message" data-msg="{{ session('edit') }}"></div>
    <div class="row">
        <div class="col-lg">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Edit Transaksi. <br> No Faktur: {{ $data->no_resi }} <br> Unit
                        {{ ($data->member->unit == 0 ? '-' : $data->member->unit) . ' | ' . $data->member->nama }}</h5>
                    <div class="row">
                        <form action="{{ route('update-transaksi') }}" method="post">
                            @csrf
                            <input type="hidden" name="no_resi" id="no_resi" value="{{ $data->no_resi }}">
                            <div class="col-8">
                                <div class="row d-flex">
                                    <div class="col-6">
                                        @if ($data->jenis_transaksi == 'pembelian')
                                            <div class="row mb-3">
                                                <label for="no_dpb" class="col-sm-5 col-form-label">No DPB</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control trans-section"
                                                            data-datats="ts-1" id="noDpb" name="no_dpb"
                                                            value="{{ $data->no_dpb }}">
                                                        <button type="button" class="input-group-text" id="btnNoDpb">
                                                            <i class="fas fa-key"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row mb-3">
                                            <label for="tanggal" class="col-sm-5 col-form-label">Tanggal Faktur</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="date" class="form-control trans-section" data-datats="ts-1"
                                                        id="tanggal" name="tanggal"
                                                        value="{{ date('Y-m-d', strtotime($data->tanggal)) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="total" class="col-sm-5 col-form-label">Total Faktur</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control trans-section" data-datats="ts-1"
                                                        id="total" name="total"
                                                        value="{{ $helper->money_format($data->total, 'Rp ') }}" required
                                                        {{ count($data->detail) > 0 ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="donasi" class="col-sm-5 col-form-label">Donasi</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control trans-section" data-datats="ts-1"
                                                        id="donasi" name="donasi"
                                                        value="{{ $helper->money_format($data->donasi, 'Rp ') }}">
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
                                        <button type="submit" class="btn btn-info btn-sm text-light" id="slsPrintTransc"><i
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

            let batal = document.querySelector('#batal');
            batal.addEventListener('click', function(e) {
                location.reload();
            });

            let is_add = $('#message').data('msg');
            if (is_add === 'succesful') {
                Swal.fire(
                    'Data berhasil Diubah!',
                    'success!',
                    'success'
                ).then((result) => {})
            } else if (is_add === 'failed') {
                Swal.fire(
                    'Data gagal Diubah!',
                    'failed!',
                    'error'
                ).then((result) => {})
            }
        })

    </script>
@endsection
