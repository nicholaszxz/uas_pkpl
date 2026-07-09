<!doctype html>
<html lang="en">

<style>
    .app-header__logo {
        width: 220px !important;
    }

    .app-header__logo .logo-src {
        width: 180px !important;
        height: 60px !important;
        background-image: url('{{ asset("assets/vendor/architectui/assets/images/logo.png") }}') !important;
        background-repeat: no-repeat !important;
        background-position: left center !important;
        background-size: contain !important;
    }
</style>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('site-title') | AHS Asean Pasifik</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url-global" content="{{ config('app.url') }}">
    <meta name="login" content="{{ session('login') }}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/favicon/ahs/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favicon/ahs/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favicon/ahs/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/ahs/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favicon/ahs/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favicon/ahs/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favicon/ahs/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ asset('assets/favicon/ahs/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/favicon/ahs/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('assets/favicon/ahs/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/ahs/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/ahs/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/ahs/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/ahs/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ahs/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Simple Date Picker -->
    <link href="{{ asset('assets/simplepicker/simplepicker.css') }}" rel="stylesheet">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.css') }}">

    <!-- Jquery cdn -->
    <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>

    <!-- Jquery QR Code -->
    <script src="{{ asset('assets/js/jquery.qrcode.min.js') }}"></script>

    <!-- Jquery UI -->
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>

    <!-- DataTables JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>

    <!-- Bootstrap-datepicker js -->
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Axios -->
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>

    <!-- FontAwesome cdn -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">

    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
    <link href="{{ asset('assets/vendor/architectui/main.css') }}" rel="stylesheet">

    <style>
        .invert-img {
            filter: invert(1);
        }

    </style>

</head>

<body style="width: 100%">
    <div id="appContainer"
        class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header closed-sidebar">

        {{-- navbar --}}
        @include('admin.temp.navbar')

        {{-- setting float button --}}
        @include('admin.temp.setfloat')

        <div class="app-main">

            {{-- sidebar --}}
            @include('admin.temp.sidebar')

            <div class="app-main__outer">

                {{-- main content --}}
                <div class="app-main__inner">
                    @yield('main-contents')
                </div>

                {{-- footer --}}
                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner">
                            <div class="app-footer-left">
                            </div>
                            <div class="app-footer-right">
                                <ul class="nav">
                                    <li class="nav-item">
                                            <span id="footerYearCopy"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    @yield('modals')

    <script type="text/javascript" src="{{ asset('assets/vendor/architectui/assets/scripts/main.js') }}"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- FontAwesome cdn -->
    <script src="{{ asset('assets/fontawesome/js/all.js') }}" crossorigin="anonymous"></script>

    <!-- Date JS -->
    <script src="{{ asset('assets/js/date.min.js') }}" crossorigin="anonymous"></script>

    <!-- SweetAlert 2 -->
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" crossorigin="anonymous"></script>

    <!-- Simple Date Picker -->
    <script src="{{ asset('assets/simplepicker/simplepicker.js') }}" crossorigin="anonymous"></script>

    <script>
        // view clock
        const globalUrl = $('meta[name=url-global]').attr('content');

        // message login succesful
        let is_login = $('meta[name=login]').attr('content');
        if (is_login == 'succesful') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3200,
                timerProgressBar: true,
                background: '',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'success',
                title: 'Signed in successfully'
            })
        }

        function currentTime() {
            var date = new Date();
            var day = date.getDay();
            var hour = date.getHours();
            var min = date.getMinutes();
            var sec = date.getSeconds();
            day = updateDay(day);
            hour = updateTime(hour);
            min = updateTime(min);
            sec = updateTime(sec);
            document.getElementById("clockZone").innerText = hour + " : " + min + " : " +
                sec + " - " + day;
            var t = setTimeout(function() {
                currentTime()
            }, 1000);
        }

        function updateTime(k) {
            if (k < 10) {
                return "0" + k;
            } else {
                return k;
            }
        }

        function updateDay(k) {
            let dayName = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            return dayName[(Number(k) - 1)].toLocaleUpperCase();
        }

        currentTime();

        // sidebar
        // let sideBar = document.getElementById('appContainer');
        // sideBar.classList.add('closed-sidebar');
        // let sideBarStyle = document.getElementById('appSidebar');
        // sideBarStyle.classList.add('bg-deep-blue');
        // sideBarStyle.classList.add('sidebar-text-dark');

        // currency IDR
        function currencyIdr(angka, prefix) {
            if (angka.includes('.') && angka.includes('Rp') == false) angka = String(Math.ceil(Number(angka)));
            let number_string = String(angka).replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }
            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
        }

        function replaceCurrency(angka) {
            return Number(angka.split(".").join("").split("Rp").join(""));
        }

        $('#footerYearCopy').html(function() {
        let date = new Date();
        return '&#169; ' + String(date.getFullYear()) + ' AHS Asean Pasifik';
    })

    </script>

    <!-- Javascript ekstra -->
    @yield('javascript')

    <!-- Javascript ekstra -->
    @yield('struk-transaksi')

</body>

</html>
