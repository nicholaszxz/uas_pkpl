@extends('admin.temp.template')

@section('site-title', 'Pembayaran Hutang')

@section('main-contents')

    <div class="tab-content">

        <!-- pembayaran piutang -->
        <div class="tab-pane tabs-animation fade show active" id="tab-content-penjualan" role="tabpanel">
            <div class="row">
                <div class="col-lg">
                    <div class="main-card mb-3 card">
                        <div class="card-body">

                            <div id="accordion">
                                <div id="headingOne">
                                    <h5 class="card-title collapsed" id="titleMemberSearch" data-toggle="collapse"
                                        data-target="#dataPiutangMember" aria-expanded="true" aria-controls="collapseOne">
                                        Search Supplier
                                        <button class="btn btn-sm text-primary" style="margin-top: -10px">
                                            <i class="fas fa-sort-down"></i>
                                        </button>
                                    </h5>
                                </div>

                                <div class="row">
                                    <div class="col-8">
                                        <div class="row d-flex">
                                            <div class="col-6">
                                                <div class="row mb-3">
                                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Kode
                                                        Supplier</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control trans-section"
                                                                data-datats="ts-1" id="memberSearch" name="memberSearch">
                                                            <button type="button" class="input-group-text"
                                                                id="btnMemberSearch" data-bs-toggle="modal"
                                                                data-bs-target="#memberModal">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div data-parent="#accordion" id="dataPiutangMember" aria-labelledby="headingOne"
                                        class="collapse">
                                        <div class="scroll-area-sm">
                                            <div class="scrollbar-container ps--active-y">
                                                <table class="mb-3 table table-striped table-member-piutang"
                                                    id="tableMember">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">No Resi</th>
                                                            <th scope="col">Tanggal</th>
                                                            <th scope="col">Hutang</th>
                                                            <th scope="col">Sisa Hutang</th>
                                                            <th scope="col">Jatuh Tempo</th>
                                                            <th scope="col">Tindakan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <table class="mb-0 table table-striped pt-4" id="tableJumlahPiutang">
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Data Hutang</h5>
                            <div class="row alert-row" style="display: none">
                                <div class="alert alert-danger alert-row" data-start="true" role="alert">
                                    Data Hutang <strong>Tidak</strong> Tersedia! Harap cek kembali form
                                    <strong>Hutang</strong> di bawah!
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="row d-flex">
                                        <div class="col-6">
                                            <div class="row mb-3">
                                                <label for="inputPassword3" class="col-sm-4 col-form-label">INVOICE</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="hidden" name="noResiHidden" id="noResiHidden">
                                                        <input type="text" class="form-control trans-section"
                                                            data-datats="ts-1" id="noResi" name="noResi">
                                                        <button type="button" class="input-group-text" id="btnResi">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="scroll-area-md">
                                            <div class="scrollbar-container ps--active-y">
                                                <table class="mb-0 table table-striped" id="tableItem">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Kode</th>
                                                            <th scope="col">Item</th>
                                                            <th scope="col">Jumlah</th>
                                                            <th scope="col">Harga</th>
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
                                        <div class="col d-flex justify-content-end">
                                            <p><strong>sisa hutang</strong></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex flex-row-reverse">
                                        <div class="col d-flex justify-content-end">
                                            <h4 class="text-danger border-bottom border-danger" id="totalText">Rp 0</h4>
                                        </div>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="text" class="form-control pay-section" data-dataps="ps-1"
                                                id="kodeMember" value="" disabled>
                                        </div>
                                        <label for="" class="col-4 col-form-label">Kode Supplier :</label>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="text" class="form-control pay-section" data-dataps="ps-3"
                                                id="uangTotal" value="">
                                        </div>
                                        <label for="inputPassword3" class="col-4 col-form-label">Uang :</label>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <div class="col-6 input-group">
                                            <input type="text" class="form-control pay-section" data-dataps="ps-4"
                                                id="kmblTotal" value="" disabled>
                                        </div>
                                        <label for="inputPassword3" class="col-4 col-form-label">Kembalian :</label>
                                    </div>
                                    <div class="row d-flex flex-row-reverse mt-2">
                                        <input type="hidden" name="isLunas" id="isLunas">
                                        <div class="col-6 input-group">
                                            <input type="text" class="form-control pay-section" data-dataps="ps-4"
                                                id="sisaPiutang" value="" disabled>
                                        </div>
                                        <label for="inputPassword3" class="col-4 col-form-label">Sisa Hutang :</label>
                                    </div>
                                    <div class="row flex-row-reverse mt-2 text-alert-lunas" style="display: none">
                                        <div class="col mt-2 text-end">
                                            <h3 class="badge badge-success">Lunas</h3>
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

    </div>

@endsection

@section('modals')
    <!-- modal data member -->
    <div class="modal fade" id="memberModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memberModalLabel">Data Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-striped table-hover table-data-member" id="tableModalMember">
                            <thead>
                                <tr>
                                    <th scope="col">Kode Supplier</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Hutang</th>
                                    <th scope="col">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
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

            // member
            $('#btnMemberSearch').on('click', function() {
                axios.get(globalUrl + 'get-supplier-search/')
                    .then((response) => {
                        let data = response.data.data;
                        memberModal(data);
                    }).catch((error) => {
                        console.log(error.response);
                    })
            });

            function memberModal(data) {
                $('.table-data-member').find('tbody').empty();
                data.forEach(member => {
                    let num = 0;
                    member.transaksi.forEach(transaksi => {
                        if (transaksi.is_lunas == '0') num += 1;
                    });
                    if (num > 0) {
                        // tambah row
                        $('.table-data-member').find('tbody').append(
                            "<tr class='item-row'><td>" +
                            member.kode_member +
                            "</td><td>" + member.nama +
                            "</td><td>" + num +
                            " transaksi</td><td><button class='btn btn-primary btn-sm text-light btn-tambah-member' data-kode='" +
                            member.kode_member +
                            "' data-bs-dismiss='modal' aria-label='Close'><i class='fas fa-plus'></i></button></td></tr>"
                        );
                    }
                });
                btnModalTambahMember();
                $('#tableModalMember').DataTable();
            }

            let btnModalTambahMember = () => $("button.btn-tambah-member").on("click", function(e) {
                var data = {
                    kode: $(this).data('kode'),
                };
                let kode = $("#memberSearch").val(data.kode);
                $('#memberSearch').change();
            });

            $('#memberSearch').on('change paste keyup', function(event) {
                axios.get(globalUrl + 'get-member-piutang/' + $(this).val())
                    .then((response) => {
                        let data = response.data.data;
                        memberTable(data)
                    }).catch((error) => {
                        console.log(error.response);
                    })
            });

            function memberTable(data) {
                $('.table-member-piutang').find('tbody').empty();
                $('#tableJumlahPiutang').empty();
                let tPiutang = 0;
                let tBayar = 0;
                let tSisa = 0;
                data.forEach(piutang => {
                    let sisa = 0;
                    for (let i = 0; i < piutang.piutang.length; i++) {
                        sisa += piutang.piutang[i].uang;
                    }
                    // tambah row
                    let mydate = new Date(piutang.tanggal);
                    let mydeadline = new Date(piutang.tanggal);
                    mydeadline.setDate(mydeadline.getDate() + 30);
                    let date = mydate.toString("d MMMM yyyy");
                    let deadline = mydeadline.toString("d MMMM yyyy");
                    $('.table-member-piutang').find('tbody').append(
                        "<tr class='row-table-member-piutang'><td>" +
                        piutang.no_resi +
                        "</td><td>" + date +
                        "</td><td>" + currencyIdr(String(piutang.total), 'Rp ') +
                        "</td><td>" + currencyIdr(String(piutang.total - sisa), 'Rp ') +
                        "</td><td>" + deadline +
                        "</td><td><button class='btn btn-primary btn-sm text-light btn-tambah-piutang' data-kode='" +
                        piutang.no_resi +
                        "' data-bs-dismiss='modal' aria-label='Close'><i class='fas fa-plus'></i></button></td></tr>"
                    );

                    tPiutang += Number(piutang.total);
                    tBayar += sisa;
                    tSisa += piutang.total - sisa;
                });
                $('#tableJumlahPiutang').append(
                    "<tr class='row-table-member-piutang'><th scope='col' collapse='4' class='text-end'>Total Hutang</th><td>" +
                    currencyIdr(String(tPiutang), 'Rp ') +
                    "</td></tr><tr class='row-table-member-piutang'><th scope='col' collapse='4' class='text-end'>Total Bayar</th><td>" +
                    currencyIdr(String(tBayar), 'Rp ') +
                    "</td></tr><tr class='row-table-member-piutang'><th scope='col' collapse='4' class='text-end'>Total Sisa Hutang</th><td>" +
                    currencyIdr(String(tSisa), 'Rp ') + "</td></tr>"
                );
                btnTambahPiutang();
                $('#titleMemberSearch').removeClass('collapsed');
                $('#dataPiutangMember').addClass('show');
            }

            let btnTambahPiutang = () => $('button.btn-tambah-piutang').on('click', function(event) {
                $('#noResi').val($(this).data('kode'));
                $('#btnResi').click();
                $('#titleMemberSearch').addClass('collapsed');
                $('#dataPiutangMember').removeClass('show');
            });

            $('#btnResi').on('click', function() {
                let inv = $('#noResi').val();
                axios.get(globalUrl + 'get-piutang/' + inv)
                    .then((response) => {
                        let data = response.data.data[0];
                        console.log(data);
                        $('#noResiHidden').val(data.no_resi);
                        $('#kodeMember').val(data.member_id);
                        tableItem(data.detail, data.total, data.diskon);
                        sumPiutang(data.piutang, data.total);
                        $('.alert-row').hide();
                    }).catch((error) => {
                        console.log(error.response);
                        $('.alert-row').show();
                    })
            });

            function tableItem(data, total, diskon) {
                $('table#tableItem').find('tbody').empty();
                for (let i = 0; i < data.length; i++) {
                    let dataLoop =
                        "<tr class='item-row'><td>" + data[i].kode_barang + "</td><td>" + data[i].nama_barang +
                        "</td><td>" + data[i].jumlah + " " + data[i].satuan + "</td><td>" +
                        currencyIdr(String(data[i].harga), 'Rp ') + "</td></tr>";
                    $('#tableItem').find('tbody').append(dataLoop);
                }
                let dataTotal = "<tr class='item-row'><td colspan='3'><strong>DISKON</strong></td><td><strong>" +
                    (diskon == null ? '0' : diskon) +
                    " %</strong></td></tr><tr class='item-row'><td colspan='3'><strong>TOTAL</strong></td><td><strong>" +
                    currencyIdr(String(total),
                        'Rp ') +
                    "</strong></td></tr>";
                $('#tableItem').find('tbody').append(dataTotal);
            }

            function sumPiutang(data, totaltr) {
                var total = 0;
                for (let i = 0; i < data.length; i++) {
                    total += data[i].uang;
                }
                totals = totaltr - total;
                $('#totalText').html(currencyIdr(String(totals), 'Rp '));
                let dataPiutang =
                    "<tr class='item-row'><td colspan='3'><strong>Pembayaran Sebelumnya</strong></td><td><strong>" +
                    currencyIdr(String(total),
                        'Rp ') +
                    "</strong></td></tr>";
                $('#tableItem').find('tbody').append(dataPiutang);
            }

            // hitung uang
            $("#uangTotal").on("change paste keyup", function() {
                $(this).val(currencyIdr($(this).val(), 'Rp '));
                let uang = Number($(this).val().split(".").join("").split("Rp").join(""));
                let total = Number($("#totalText").html().split(".").join("").split("Rp").join(""));
                let kmbl = uang - total;
                if (kmbl < 0) {
                    $("#kmblTotal").val('');
                    let sisa = total - uang;
                    $('#sisaPiutang').val(currencyIdr(String(sisa), 'Rp '));
                    $('.text-alert-lunas').hide();
                    $('#isLunas').val('0');
                } else {
                    $("#kmblTotal").val(currencyIdr(String(kmbl), 'Rp '));
                    $('#slsPrintTransc').prop('disabled', false);
                    $('.text-alert-total').hide();
                    $(this).removeClass('text-danger');
                    $('#sisaPiutang').val('');
                    $('.text-alert-lunas').show();
                    $('#isLunas').val('1');
                }
            });
            // end

            // btn selesai
            $('#slsPrintTransc').on('click', function() {
                let noResi = $('#noResiHidden').val();
                let uang = $('#uangTotal').val();
                let kmbl = $('#kmblTotal').val();
                let sisa = $('#sisaPiutang').val();
                let isLunas = $('#isLunas').val();
                let saldoAwal = $('#totalText').html();

                // proses ajax simpan
                let token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                axios.post(globalUrl + 'store-piutang', {
                        no_resi: noResi,
                        uang: replaceCurrency(uang),
                        is_lunas: isLunas
                    })
                    .then((response) => {
                        let data = response.data.data;
                        console.log(response.data.data.id);
                        console.log(replaceCurrency(saldoAwal));
                        console.log(replaceCurrency(sisa));
                        let dataStruk = {
                            noResi: data.transaksi_id,
                            piutangId: data.id,
                            saldoAwal: replaceCurrency(saldoAwal),
                            sisaPiutang: replaceCurrency(sisa)
                        };
                        printStruk(dataStruk);
                        Swal.fire(
                            'Berhasil',
                            'Pembayaran Piutang Sukses!',
                            'success'
                        )
                        $('#batal').click();
                    })
                    .catch((error) => {
                        console.log(error)
                        console.log(error.response)
                    });
                // end

            });
            // end

            // proses print strik
            function printStruk(data) {
                let printStruk = window.open(globalUrl + 'faktur/' + data.noResi);
                let tmout = setTimeout(function() {
                    printStruk.close()
                }, 3000);
            }
            // end

            // btn batal
            $('#batal').on('click', function() {
                $('#memberSearch').val('');
                $('.row-table-member-piutang').remove();
                $('#noResi').val('');
                $('#noResiHidden').val('');
                $('#totalText').html('Rp 0');
                $('#kodeMember').val('');
                $('#uangTotal').val('');
                $('#kmblTotal').val('');
                $('#sisaPiutang').val('');
                $('#isLunas').val('');
                $('.text-alert-lunas').hide();
                $('.item-row').remove();
                $('#titleMemberSearch').addClass('collapsed');
                $('#dataPiutangMember').removeClass('show');
            });
            // end

        })

    </script>
@endsection
