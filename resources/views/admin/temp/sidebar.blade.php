<div id="appSidebar" class="app-sidebar sidebar-shadow bg-deep-blue sidebar-text-dark">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="/" class="<?php if ($sideTitle == 'dashboard') {
                        echo 'mm-active';
                    } ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Dashboard
                    </a>
                </li>

                <li class="app-sidebar__heading">Transaksi</li>
                <li>

                    {{-- penjualan --}}
                    @if ($level == 1 || $level == 2 || $level == 3 || $level == 5)
                        <a href="#" class="<?php if ($sideTitle == 'transaksi' || $sideTitle == 'laporan' || $sideTitle == 'retail') {
                            echo 'mm-active';
                        } ?>">
                            <i class="metismenu-icon pe-7s-cart"></i>
                            Penjualan
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            {{-- @if ($level != 5) --}}
                            <li>
                                <a href="{{ route('laporan') }}"
                                    class="{{ $sideTitle == 'laporan' ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Laporan Penjualan
                                </a>
                            </li>
                            {{-- @endif --}}
                            <li>
                                <a href="{{ route('retail') }}"
                                    class="{{ $sideTitle == 'retail' ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Penjualan MMT
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('transaksi') }}"
                                    class="{{ $sideTitle == 'transaksi' ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Penjualan
                                </a>
                            </li>
                        </ul>
                </li>
                @endif

                @if ($level != 5)
                    {{-- pembelian --}}
                    @if ($level == 1 || $level == 2 || $level == 4)
                        <li>
                            <a href="#" class="<?php if ($sideTitle == 'pembelian' || $sideTitle == 'lpembelian') {
                                echo 'mm-active';
                            } ?>">
                                <i class="metismenu-icon pe-7s-back-2"></i>
                                Pembelian
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('daftar-pembelian') }}"
                                        class="{{ $sideTitle == 'lpembelian' ? 'mm-active' : '' }}">
                                        <i class="metismenu-icon"></i>
                                        Laporan Pembelian
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pembelian') }}"
                                        class="{{ $sideTitle == 'pembelian' ? 'mm-active' : '' }}">
                                        <i class="metismenu-icon"></i>
                                        Pembelian
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- piutang --}}
                    @if ($level == 1 || $level == 2 || $level == 3)
                        <li>
                            <a href="#" class="<?php if ($sideTitle == 'piutang' || $sideTitle == 'daftarpiutang' || $sideTitle == 'sa-piutang') {
                                echo 'mm-active';
                            } ?>">
                                <i class="metismenu-icon pe-7s-hammer"></i>
                                Piutang
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('d-piutang') }}"
                                        class="{{ $sideTitle == 'daftarpiutang' ? 'mm-active' : '' }}">
                                        <i class="metismenu-icon"></i>
                                        Laporan Piutang
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('piutang') }}"
                                        class="{{ $sideTitle == 'piutang' ? 'mm-active' : '' }}">
                                        <i class="metismenu-icon"></i>
                                        Cicilan Piutang
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('sa-piutang') }}"
                                        class="{{ $sideTitle == 'sa-piutang' ? 'mm-active' : '' }}">
                                        <i class="metismenu-icon"></i>
                                        Input Saldo Awal Piutang
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- hutang --}}
                    @if ($level == 1 || $level == 2 || $level == 4)
                        <li>
                            <a href="#" class="<?php if ($sideTitle == 'daftarhutang' || $sideTitle == 'sa-hutang' || $sideTitle == 'hutang') {
                                echo 'mm-active';
                            } ?>">
                                <i class="metismenu-icon pe-7s-cash"></i>
                                Hutang
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('d-hutang') }}"
                                        class="{{ $sideTitle == 'daftarhutang' ? 'mm-active' : '' }}">
                                        <i class="metismenu-icon"></i>
                                        Laporan Hutang
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('hutang') }}"
                                        class="{{ $sideTitle == 'hutang' ? 'mm-active' : '' }}">
                                        <i class="metismenu-icon"></i>
                                        Cicilan Hutang
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('sa-hutang') }}"
                                        class="{{ $sideTitle == 'sa-hutang' ? 'mm-active' : '' }}">
                                        <i class="metismenu-icon"></i>
                                        Input Saldo Awal Hutang
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- print struk --}}
                    @if ($level != 5)
                        <li>
                            <a href="{{ route('printstruk') }}"
                                class="{{ $sideTitle == 'printstruk' ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-print"></i>
                                Print Struk / Faktur
                            </a>
                        </li>
                    @endif


                    <li class="app-sidebar__heading">STOKIS</li>
                    {{-- Barang --}}
                    <li>
                        <a href="#" class="<?php if ($sideTitle == 'barang' || $sideTitle == '') {
                            echo 'mm-active';
                        } ?>">
                            <i class="metismenu-icon pe-7s-box1"></i>
                            Barang
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('barang') }}"
                                    class="{{ $sideTitle == 'barang' ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Input Barang
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('jenis') }}"
                                    class="{{ $sideTitle == 'jenis-barang' ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon"></i>
                                    Tambah Jenis Barang
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Human Resource --}}
                    <li class="app-sidebar__heading">HR</li>
                    {{-- Anggota --}}
                    <li>
                        <a href="{{ route('member') }}" class="{{ $sideTitle == 'member' ? 'mm-active' : '' }}">
                            <i class="metismenu-icon pe-7s-diamond"></i>
                            Daftar Anggota
                        </a>
                    </li>
                    {{-- Supplier --}}
                    <li>
                        <a href="{{ route('supplier') }}"
                            class="{{ $sideTitle == 'supplier' ? 'mm-active' : '' }}">
                            <i class="metismenu-icon pe-7s-id"></i>
                            Daftar Supplier
                        </a>
                    </li>
                    @if ($level == 1 || $level == 2)
                        {{-- User --}}
                        <li>
                            <a href="{{ route('user') }}" class="{{ $sideTitle == 'user' ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-users"></i>
                                Info User
                            </a>
                        </li>
                    @endif
                @endif

        </div>
    </div>
</div>
