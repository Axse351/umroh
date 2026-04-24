<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/dashboard') }}">Travel Umroh & Haji</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/dashboard') }}">TUH</a>
        </div>

        <ul class="sidebar-menu">

            {{-- ==================== DASHBOARD ==================== --}}
            <li class="menu-header">Dashboard</li>

            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @auth

                {{-- ==================== DATA DASHBOARD ==================== --}}
                <li class="menu-header">Data Dashboard</li>

                {{-- Total Transaksi --}}
                <li class="dropdown {{ request()->is('dashboard/transaksi*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-chart-line"></i>
                        <span>Total Transaksi</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('dashboard/transaksi-umroh') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/transaksi-umroh') }}">
                                Total Transaksi Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('dashboard/transaksi-haji') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/transaksi-haji') }}">
                                Total Transaksi Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Total Jamaah --}}
                <li class="dropdown {{ request()->is('dashboard/jamaah*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-users"></i>
                        <span>Total Jamaah</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('dashboard/jamaah-umroh') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/jamaah-umroh') }}">
                                Total Jamaah Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('dashboard/jamaah-haji') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/jamaah-haji') }}">
                                Total Jamaah Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Sudah Membayar --}}
                <li class="dropdown {{ request()->is('dashboard/bayar*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Sudah Membayar</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('dashboard/bayar-umroh') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/bayar-umroh') }}">
                                Sudah Membayar Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('dashboard/bayar-haji') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/bayar-haji') }}">
                                Sudah Membayar Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Sisa Tagihan --}}
                <li class="dropdown {{ request()->is('dashboard/tagihan*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Sisa Tagihan</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('dashboard/tagihan-umroh') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/tagihan-umroh') }}">
                                Sisa Tagihan Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('dashboard/tagihan-haji') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/tagihan-haji') }}">
                                Sisa Tagihan Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Data Tabungan Dashboard --}}
                <li class="dropdown {{ request()->is('dashboard/tabungan*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-piggy-bank"></i>
                        <span>Data Tabungan</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('dashboard/tabungan-umroh') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/tabungan-umroh') }}">
                                Tabungan Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('dashboard/tabungan-haji') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/tabungan-haji') }}">
                                Tabungan Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Total Tabungan --}}
                <li class="dropdown {{ request()->is('dashboard/total-tabungan*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Total Tabungan</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('dashboard/total-tabungan-umroh') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/total-tabungan-umroh') }}">
                                Total Tabungan Jamaah Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('dashboard/total-tabungan-haji') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard/total-tabungan-haji') }}">
                                Total Tabungan Jamaah Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ==================== MENU TRAVEL ==================== --}}
                <li class="menu-header">Menu Travel</li>

                {{-- Data Pendaftaran --}}
                <li class="dropdown {{ request()->is('pendaftaran*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Data Pendaftaran</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('pendaftaran/umroh*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/pendaftaran/umroh') }}">
                                Pendaftaran Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('pendaftaran/haji*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/pendaftaran/haji') }}">
                                Pendaftaran Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Data Jamaah --}}
                <li class="dropdown {{ request()->is('jamaah*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-users"></i>
                        <span>Data Jamaah</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('jamaah/umroh*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/jamaah/umroh') }}">
                                Jamaah Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('jamaah/haji*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/jamaah/haji') }}">
                                Jamaah Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Data Agent --}}
                <li class="dropdown {{ request()->is('agent*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-user-tie"></i>
                        <span>Data Agent</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('agent/umroh*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/agent/umroh') }}">
                                Agent Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('agent/haji*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/agent/haji') }}">
                                Agent Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Data Karyawan --}}
                <li class="{{ request()->is('karyawan*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/karyawan') }}">
                        <i class="fas fa-id-badge"></i>
                        <span>Data Karyawan</span>
                    </a>
                </li>

                {{-- Data Paket --}}
                <li class="{{ request()->is('paket*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/paket') }}">
                        <i class="fas fa-box-open"></i>
                        <span>Data Paket</span>
                    </a>
                </li>

                {{-- Data Keberangkatan --}}
                <li class="{{ request()->is('keberangkatan*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/keberangkatan') }}">
                        <i class="fas fa-plane-departure"></i>
                        <span>Data Keberangkatan</span>
                    </a>
                </li>

                {{-- Data Pembayaran --}}
                <li class="{{ request()->is('pembayaran*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/pembayaran') }}">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Data Pembayaran</span>
                    </a>
                </li>

                {{-- Data Pengeluaran --}}
                <li class="{{ request()->is('pengeluaran*') && !request()->is('pengeluaran-produk*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/pengeluaran') }}">
                        <i class="fas fa-arrow-circle-down"></i>
                        <span>Data Pengeluaran</span>
                    </a>
                </li>

                {{-- Data Pemasukan --}}
                <li class="{{ request()->is('pemasukan*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/pemasukan') }}">
                        <i class="fas fa-arrow-circle-up"></i>
                        <span>Data Pemasukan</span>
                    </a>
                </li>

                {{-- Data Laporan --}}
                <li class="{{ request()->is('laporan*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/laporan') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Data Laporan</span>
                    </a>
                </li>

                {{-- Data Dokumen --}}
                <li class="{{ request()->is('dokumen*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/dokumen') }}">
                        <i class="fas fa-folder-open"></i>
                        <span>Data Dokumen</span>
                    </a>
                </li>

                {{-- Data Maskapai --}}
                <li class="{{ request()->is('maskapai*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/maskapai') }}">
                        <i class="fas fa-plane"></i>
                        <span>Data Maskapai</span>
                    </a>
                </li>

                {{-- Data Hotel --}}
                <li class="{{ request()->is('hotel*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/hotel') }}">
                        <i class="fas fa-hotel"></i>
                        <span>Data Hotel</span>
                    </a>
                </li>

                {{-- ==================== MENU LAYANAN ==================== --}}
                <li class="menu-header">Menu Layanan</li>

                {{-- Data Mitra --}}
                <li class="{{ request()->is('mitra*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/mitra') }}">
                        <i class="fas fa-handshake"></i>
                        <span>Data Mitra</span>
                    </a>
                </li>

                {{-- Data Layanan --}}
                <li class="dropdown {{ request()->is('layanan*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-concierge-bell"></i>
                        <span>Data Layanan</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('layanan/umroh*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/layanan/umroh') }}">
                                Layanan Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('layanan/haji*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/layanan/haji') }}">
                                Layanan Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Transaksi Layanan --}}
                <li class="dropdown {{ request()->is('transaksi-layanan*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-receipt"></i>
                        <span>Transaksi Layanan</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('transaksi-layanan/umroh*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/transaksi-layanan/umroh') }}">
                                Transaksi Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('transaksi-layanan/haji*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/transaksi-layanan/haji') }}">
                                Transaksi Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Data Tabungan --}}
                <li class="dropdown {{ request()->is('tabungan*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-piggy-bank"></i>
                        <span>Data Tabungan</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('tabungan/umroh*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/tabungan/umroh') }}">
                                Tabungan Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('tabungan/haji*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/tabungan/haji') }}">
                                Tabungan Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Data Setoran --}}
                <li class="dropdown {{ request()->is('setoran*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-wallet"></i>
                        <span>Data Setoran</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->is('setoran/umroh*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/setoran/umroh') }}">
                                Setoran Umroh
                            </a>
                        </li>
                        <li class="{{ request()->is('setoran/haji*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/setoran/haji') }}">
                                Setoran Haji
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ==================== MENU GUDANG ==================== --}}
                <li class="menu-header">Menu Gudang</li>

                {{-- Data Produk --}}
                <li class="{{ request()->is('produk*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/produk') }}">
                        <i class="fas fa-box"></i>
                        <span>Data Produk</span>
                    </a>
                </li>

                {{-- Stok Opname --}}
                <li class="{{ request()->is('stok-opname*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/stok-opname') }}">
                        <i class="fas fa-warehouse"></i>
                        <span>Stok Opname</span>
                    </a>
                </li>

                {{-- Pembelian Produk --}}
                <li class="{{ request()->is('pembelian*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/pembelian') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Pembelian Produk</span>
                    </a>
                </li>

                {{-- Pengeluaran Produk --}}
                <li class="{{ request()->is('pengeluaran-produk*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/pengeluaran-produk') }}">
                        <i class="fas fa-dolly"></i>
                        <span>Pengeluaran Produk</span>
                    </a>
                </li>

                {{-- Data Supplier --}}
                <li class="{{ request()->is('supplier*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/supplier') }}">
                        <i class="fas fa-truck"></i>
                        <span>Data Supplier</span>
                    </a>
                </li>

                {{-- ==================== PENGATURAN ==================== --}}
                <li class="menu-header">Pengaturan</li>

                {{-- Akses System --}}
                <li class="{{ request()->is('akses-system*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/akses-system') }}">
                        <i class="fas fa-shield-alt"></i>
                        <span>Akses System</span>
                    </a>
                </li>

                {{-- Setting --}}
                <li class="{{ request()->is('setting*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/setting') }}">
                        <i class="fas fa-cog"></i>
                        <span>Setting</span>
                    </a>
                </li>

            @endauth

        </ul>
    </aside>
</div>
