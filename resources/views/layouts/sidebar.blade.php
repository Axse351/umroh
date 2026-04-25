<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">Travel Umroh & Haji</a>
        </div>

        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">TUH</a>
        </div>

        <ul class="sidebar-menu">

            {{-- ==================== DASHBOARD ==================== --}}
            <li class="menu-header">Dashboard</li>

            <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- ==================== DATA DASHBOARD ==================== --}}
            <li class="menu-header">Data Dashboard</li>

            <li class="dropdown {{ request()->is('admin/dashboard/transaksi*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-chart-line"></i>
                    <span>Total Transaksi</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ url('admin/dashboard/transaksi-umroh') }}">
                            Total Transaksi Umroh
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ url('admin/dashboard/transaksi-haji') }}">
                            Total Transaksi Haji
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ==================== MENU TRAVEL ==================== --}}
            <li class="menu-header">Menu Travel</li>

            <li class="{{ request()->is('admin/pendaftaran*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pendaftaran.index') }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Data Pendaftaran</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/jamaah*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.jamaah.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Data Jamaah</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/agent*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.agent.index') }}">
                    <i class="fas fa-user-tie"></i>
                    <span>Data Agent</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/karyawan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.karyawan.index') }}">
                    <i class="fas fa-id-badge"></i>
                    <span>Data Karyawan</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/paket*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.paket.index') }}">
                    <i class="fas fa-box-open"></i>
                    <span>Data Paket</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/keberangkatan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.keberangkatan.index') }}">
                    <i class="fas fa-plane-departure"></i>
                    <span>Data Keberangkatan</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/pembayaran*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pembayaran.index') }}">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Data Pembayaran</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/pengeluaran*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pengeluaran.index') }}">
                    <i class="fas fa-arrow-circle-down"></i>
                    <span>Data Pengeluaran</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/pemasukan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pemasukan.index') }}">
                    <i class="fas fa-arrow-circle-up"></i>
                    <span>Data Pemasukan</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/laporan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Data Laporan</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/dokumen*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dokumen.index') }}">
                    <i class="fas fa-folder-open"></i>
                    <span>Data Dokumen</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/maskapai*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.maskapai.index') }}">
                    <i class="fas fa-plane"></i>
                    <span>Data Maskapai</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/hotel*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.hotel.index') }}">
                    <i class="fas fa-hotel"></i>
                    <span>Data Hotel</span>
                </a>
            </li>

            {{-- ==================== MENU LAYANAN ==================== --}}
            <li class="menu-header">Menu Layanan</li>

            <li class="{{ request()->is('admin/mitra*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.mitra.index') }}">
                    <i class="fas fa-handshake"></i>
                    <span>Data Mitra</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/layanan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.layanan.index') }}">
                    <i class="fas fa-concierge-bell"></i>
                    <span>Data Layanan</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/transaksi-layanan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.transaksi-layanan.index') }}">
                    <i class="fas fa-receipt"></i>
                    <span>Transaksi Layanan</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/tabungan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.tabungan.index') }}">
                    <i class="fas fa-piggy-bank"></i>
                    <span>Data Tabungan</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/setoran*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.setoran.index') }}">
                    <i class="fas fa-wallet"></i>
                    <span>Data Setoran</span>
                </a>
            </li>

            {{-- ==================== MENU GUDANG ==================== --}}
            <li class="menu-header">Menu Gudang</li>

            <li class="{{ request()->is('admin/produk*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.produk.index') }}">
                    <i class="fas fa-box"></i>
                    <span>Data Produk</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/stok-opname*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.stok-opname.index') }}">
                    <i class="fas fa-warehouse"></i>
                    <span>Stok Opname</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/pembelian*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pembelian.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pembelian Produk</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/pengeluaran-produk*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pengeluaran-produk.index') }}">
                    <i class="fas fa-dolly"></i>
                    <span>Pengeluaran Produk</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/supplier*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.supplier.index') }}">
                    <i class="fas fa-truck"></i>
                    <span>Data Supplier</span>
                </a>
            </li>

            {{-- ==================== PENGATURAN ==================== --}}
            <li class="menu-header">Pengaturan</li>

            <li class="{{ request()->is('admin/akses-system*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.akses-system.index') }}">
                    <i class="fas fa-shield-alt"></i>
                    <span>Akses System</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/setting*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.setting.index') }}">
                    <i class="fas fa-cog"></i>
                    <span>Setting</span>
                </a>
            </li>

        </ul>
    </aside>
</div>
