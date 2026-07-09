@extends('admin.temp.template')

@section('site-title', 'Daftar Print Struk')

@section('main-contents')
    <div id="message" data-msg="{{ session('add') }}"></div>
    <div class="row">
        <div class="col-lg">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title d-inline-block mr-3">Daftar Faktur</h5>
                    <a href="{{ route('printstruk') }}" class="btn btn-warning d-inline-block"><i
                            class="fas fa-sync-alt"></i>
                        Refresh</a>
                    <hr>
                    <div class="row">
                        <div class="col-8">
                            <div class="row d-flex">
                                <div class="col-6">
                                    <div class="row mb-3">
                                        <label for="noFaktur" class="col-sm-5 col-form-label">No Faktur</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control trans-section" data-datats="ts-1"
                                                    id="noFaktur" name="noFaktur" value="{{ $faktur }}" required>
                                                <button type="button" class="input-group-text" id="btnnoFaktur">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col">
                            <table class="table table-striped table-hover table-data-faktur" id="tableFaktur">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">No Resi</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Kasir</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Anggota</th>
                                        <th scope="col">Jenis Transaksi</th>
                                        <th scope="col">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $transaksi)
                                        <tr>
                                            <th scope="col">{{ $loop->iteration }}</th>
                                            <td>{{ $transaksi->no_resi }}</td>
                                            <td>{{ date('d/m/y H:i:s', strtotime($transaksi->tanggal)) }}</td>
                                            <td>{{ $transaksi->kasir->name }}</td>
                                            <td>{{ $transaksi->member->unit }}</td>
                                            <td>{{ $transaksi->member->nama }}</td>
                                            <td>{{ $transaksi->jenis_transaksi == 'pengiriman' ? 'MMT' : 'Piutang' }}
                                            </td>
                                            <td>
                                                @if ($transaksi->jenis_transaksi == 'penjualan')
                                                    <a href="/faktur-piutang/{{ $transaksi->no_resi }}" target="_blank"
                                                        class="btn btn-danger"><i class="fas fa-print"></i></a>
                                                @else
                                                    <a href="/faktur-retail/{{ $transaksi->no_resi }}" target="_blank"
                                                        class="btn btn-danger"><i class="fas fa-print"></i></a>
                                                    <a href="/faktur-retail/{{ $transaksi->no_resi }}" target="_blank"
                                                        class="btn btn-warning"><i class="fas fa-scroll"></i></a>
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
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        (function() {
            $('#tableFaktur').DataTable();
            let btnFaktur = document.querySelector('#btnnoFaktur');
            btnFaktur.addEventListener('click', function(e) {
                let faktur = document.querySelector('#noFaktur').value;
                if (faktur == '') {
                    alert('Masukkan No Faktur');
                } else {
                    window.location.replace(`${globalUrl}print-struk/${faktur}`);
                }
            });
        })();

    </script>
@endsection
