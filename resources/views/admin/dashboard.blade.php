@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('breadcrumb')
    <div class="breadcrumb-item active">Dashboard</div>
@endsection

@push('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

/* ── Global ── */
body,
.main-content {
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    background-color: #f5f6fa !important;
}

/* ═══════════════════════════════════════════
   CARD STATISTIC-1 (Row 1)
═══════════════════════════════════════════ */
.card-statistic-1 {
    border: 0.5px solid #eceef5 !important;
    border-radius: 12px !important;
    box-shadow: none !important;
    overflow: visible !important;
}

.card-statistic-1 .card-icon {
    border-radius: 10px !important;
    width: 44px !important;
    height: 44px !important;
    line-height: 44px !important;
    font-size: 18px !important;
    margin: 18px 0 0 18px !important;
    flex-shrink: 0;
    box-shadow: none !important;
}

.card-statistic-1 .card-icon.bg-warning { background: #fff7e8 !important; color: #f5a623 !important; }
.card-statistic-1 .card-icon.bg-success { background: #e8f8ee !important; color: #27ae60 !important; }
.card-statistic-1 .card-icon.bg-primary { background: #eaedff !important; color: #3b5bdb !important; }
.card-statistic-1 .card-icon.bg-danger  { background: #ffe9e9 !important; color: #e03131 !important; }

.card-statistic-1 .card-header {
    background: transparent !important;
    border-bottom: none !important;
    padding: 14px 18px 0 !important;
}

.card-statistic-1 .card-header h4 {
    font-size: 11.5px !important;
    font-weight: 500 !important;
    color: #9499b0 !important;
    letter-spacing: 0 !important;
    text-transform: none !important;
    margin-bottom: 0 !important;
}

.card-statistic-1 .card-body {
    font-size: 26px !important;
    font-weight: 600 !important;
    color: #1a1d2e !important;
    padding: 2px 18px 6px !important;
    line-height: 1.15 !important;
}

/* ── Stat card "lihat semua" link ── */
.stat-see-all {
    display: block;
    text-align: right;
    font-size: 11px;
    color: #3b5bdb;
    font-weight: 500;
    padding: 0 18px 14px;
    text-decoration: none;
}
.stat-see-all:hover { color: #2848c8; text-decoration: none; }

/* ═══════════════════════════════════════════
   BADGES
═══════════════════════════════════════════ */
.badge {
    font-size: 10.5px !important;
    font-weight: 500 !important;
    padding: 3px 9px !important;
    border-radius: 20px !important;
}

.badge-success   { background: #e8f8ee !important; color: #1e8449 !important; }
.badge-secondary { background: #f0f0f5 !important; color: #636878 !important; }
.badge-danger    { background: #ffe9e9 !important; color: #c0392b !important; }
.badge-primary   { background: #eaedff !important; color: #3b5bdb !important; }
.badge-info      { background: #e8f4ff !important; color: #1971c2 !important; }
.badge-light     { background: #f0f0f5 !important; color: #636878 !important; }
.badge-warning   { background: #fff7e8 !important; color: #c77b00 !important; }
.badge-dark      { background: #e8e8ee !important; color: #333 !important; }

.stat-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    padding: 0 18px 14px;
    margin-top: 0;
}

/* ═══════════════════════════════════════════
   CARD UMUM (Row 2+)
═══════════════════════════════════════════ */
.card {
    border: 0.5px solid #eceef5 !important;
    border-radius: 12px !important;
    box-shadow: none !important;
}

.card-header {
    background: #fafbff !important;
    border-bottom: 0.5px solid #eceef5 !important;
    padding: 13px 18px !important;
    border-radius: 12px 12px 0 0 !important;
}

.card-header h4 {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #1a1d2e !important;
    margin-bottom: 0 !important;
    display: flex;
    align-items: center;
}

.card-header .card-header-action .btn {
    font-size: 11px !important;
    padding: 4px 13px !important;
    border-radius: 7px !important;
    font-weight: 500 !important;
    box-shadow: none !important;
}

.card-header .btn-primary  { background: #3b5bdb !important; border-color: #3b5bdb !important; }
.card-header .btn-warning  { background: #f5a623 !important; border-color: #f5a623 !important; color: #fff !important; }

/* ── Row 2 card body numbers ── */
.card-body h2 {
    font-size: 28px !important;
    font-weight: 600 !important;
    color: #1a1d2e !important;
    margin-bottom: 10px !important;
}

.card-body h2.text-warning { color: #f5a623 !important; }

/* ── Progress ── */
.progress {
    height: 3px !important;
    border-radius: 2px !important;
    background: #eceef5 !important;
    margin: 8px 0 5px !important;
}
.progress-bar.bg-warning { background: #f5a623 !important; }

/* ═══════════════════════════════════════════
   REVENUE CARD
═══════════════════════════════════════════ */
.card-revenue {
    background: linear-gradient(140deg, #2d3a8c 0%, #3b5bdb 60%, #4c6ef5 100%) !important;
    border-radius: 12px !important;
    border: none !important;
    padding: 20px !important;
    box-shadow: none !important;
    color: #fff;
    position: relative;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 148px;
}

.card-revenue::before {
    content: '';
    position: absolute;
    right: -24px; top: -24px;
    width: 100px; height: 100px;
    border-radius: 50%;
    background: rgba(255,255,255,.08);
}

.card-revenue::after {
    content: '';
    position: absolute;
    right: 14px; bottom: -32px;
    width: 80px; height: 80px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
}

/* ═══════════════════════════════════════════
   TABLE
═══════════════════════════════════════════ */
.table th {
    font-size: 10.5px !important;
    font-weight: 600 !important;
    color: #9499b0 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    padding: 10px 18px !important;
    background: #fafbff !important;
    border-bottom: 0.5px solid #eceef5 !important;
    border-top: none !important;
}

.table td {
    font-size: 12.5px !important;
    color: #4b5068 !important;
    padding: 10px 18px !important;
    vertical-align: middle !important;
    border-color: #f3f4f8 !important;
}

.table-hover tbody tr:hover {
    background-color: #fafbff !important;
}

.avatar-init {
    width: 30px !important;
    height: 30px !important;
    border-radius: 50% !important;
    background: #eaedff !important;
    color: #3b5bdb !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-weight: 600 !important;
    font-size: 12px !important;
    flex-shrink: 0 !important;
}

/* ═══════════════════════════════════════════
   KEBERANGKATAN MENDATANG
═══════════════════════════════════════════ */
.kb-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 0.5px solid #f3f4f8;
}
.kb-item:last-child { border-bottom: none; }

.kb-date {
    text-align: center;
    background: #f5f6fa;
    border-radius: 8px;
    padding: 6px 10px;
    min-width: 44px;
    flex-shrink: 0;
}

.kb-date .day {
    font-size: 18px !important;
    font-weight: 700 !important;
    line-height: 1 !important;
    color: #1a1d2e !important;
}

.kb-date .mon {
    font-size: 9.5px !important;
    font-weight: 600 !important;
    color: #9499b0 !important;
    text-transform: uppercase !important;
}

/* ═══════════════════════════════════════════
   SIDEBAR & NAVBAR
═══════════════════════════════════════════ */
.main-sidebar {
    box-shadow: none !important;
    border-right: 0.5px solid #eceef5 !important;
}

.navbar-bg {
    box-shadow: none !important;
    border-bottom: 0.5px solid #eceef5 !important;
}

/* ── Bell pulse ── */
.icon-bell-pulse {
    animation: bellpulse 2s infinite;
}
@keyframes bellpulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .6; transform: scale(.92); }
}

/* ── Chart canvas max height ── */
#chartPendaftaran { max-height: 280px; }

/* ── Spacing tweak for row 2 last col ── */
@media (min-width: 992px) {
    .col-lg-3.d-flex { display: flex !important; }
    .col-lg-3.d-flex .card-revenue { width: 100%; }
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
 ROW 1 — 4 stat cards utama
══════════════════════════════════════════ --}}
<div class="row">

    {{-- Pendaftaran Haji --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-kaaba"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Pendaftaran Haji</h4>
                </div>
                <div class="card-body">{{ number_format($totalPendaftaranHaji) }}</div>
                <div class="stat-badges">
                    <span class="badge badge-success">{{ $pendaftaranHajiAktif }} aktif</span>
                    <span class="badge badge-secondary">{{ $pendaftaranHajiSelesai }} selesai</span>
                    <span class="badge badge-danger">{{ $pendaftaranHajiBatal }} batal</span>
                </div>
                <a href="{{ route('admin.pendaftaran.index', ['jenis' => 'haji']) }}" class="stat-see-all">
                    Lihat semua &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Pendaftaran Umroh --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-mosque"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Pendaftaran Umroh</h4>
                </div>
                <div class="card-body">{{ number_format($totalPendaftaranUmroh) }}</div>
                <div class="stat-badges">
                    <span class="badge badge-success">{{ $pendaftaranUmrohAktif }} aktif</span>
                    <span class="badge badge-secondary">{{ $pendaftaranUmrohSelesai }} selesai</span>
                    <span class="badge badge-danger">{{ $pendaftaranUmrohBatal }} batal</span>
                </div>
                <a href="{{ route('admin.pendaftaran.index', ['jenis' => 'umroh']) }}" class="stat-see-all">
                    Lihat semua &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Total Maskapai --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-plane"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Maskapai</h4>
                </div>
                <div class="card-body">{{ number_format($totalMaskapai) }}</div>
                <div class="stat-badges">
                    <span class="badge badge-primary">{{ $maskapaiAktif }} aktif</span>
                    <span class="badge badge-light">{{ $totalMaskapai - $maskapaiAktif }} nonaktif</span>
                </div>
                <a href="{{ route('admin.maskapai.index') }}" class="stat-see-all">
                    Lihat semua &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Data Jamaah --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Data Jamaah</h4>
                </div>
                <div class="card-body">{{ number_format($totalJamaah) }}</div>
                <div class="stat-badges">
                    <span class="badge badge-info">{{ $totalUser }} user sistem</span>
                </div>
                <a href="{{ route('admin.jamaah.index') }}" class="stat-see-all">
                    Lihat semua &rarr;
                </a>
            </div>
        </div>
    </div>

</div>{{-- /row 1 --}}


{{-- ══════════════════════════════════════════
 ROW 2 — Paket · Keberangkatan · Konfirmasi · Pendapatan
══════════════════════════════════════════ --}}
<div class="row">

    {{-- Paket --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-box-open text-warning mr-2" style="font-size:13px;"></i>Total Paket</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.paket.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
            <div class="card-body">
                <h2>{{ $totalPaket }}</h2>
                <div class="d-flex justify-content-between text-muted mb-2" style="font-size:.8rem;">
                    <span><i class="fas fa-kaaba text-warning mr-1"></i>Haji: <strong>{{ $paketHaji }}</strong></span>
                    <span><i class="fas fa-mosque text-success mr-1"></i>Umroh: <strong>{{ $paketUmroh }}</strong></span>
                </div>
                <div class="progress">
                    @php $pctHaji = $totalPaket > 0 ? ($paketHaji / $totalPaket * 100) : 0; @endphp
                    <div class="progress-bar bg-warning" style="width:{{ $pctHaji }}%"></div>
                </div>
                <small class="text-muted" style="font-size:11px;">{{ $paketAktif }} aktif dari {{ $totalPaket }} total</small>
            </div>
        </div>
    </div>

    {{-- Keberangkatan --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-paper-plane text-primary mr-2" style="font-size:13px;"></i>Keberangkatan</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.keberangkatan.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
            <div class="card-body">
                <h2>{{ $totalKeberangkatan }}</h2>
                <div class="d-flex justify-content-between text-muted mb-2" style="font-size:.8rem;">
                    <span><i class="fas fa-door-open text-primary mr-1"></i>Open: <strong>{{ $keberangkatanAktif }}</strong></span>
                    <span><i class="fas fa-calendar text-info mr-1"></i>Bulan ini: <strong>{{ $keberangkatanBulanIni }}</strong></span>
                </div>
                <span class="badge badge-primary">
                    <i class="fas fa-arrow-right mr-1"></i>{{ $keberangkatanMendatang->count() }} jadwal mendatang
                </span>
            </div>
        </div>
    </div>

    {{-- Konfirmasi Pembayaran --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-bell {{ $pembayaranPending + $pembayaranVerifikasi > 0 ? 'text-warning icon-bell-pulse' : 'text-muted' }} mr-2" style="font-size:13px;"></i>
                    Perlu Konfirmasi
                </h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.pembayaran.index', ['status' => 'pending']) }}" class="btn btn-warning btn-sm">Proses</a>
                </div>
            </div>
            <div class="card-body">
                <h2 class="{{ $pembayaranPending + $pembayaranVerifikasi > 0 ? 'text-warning' : '' }}">
                    {{ $pembayaranPending + $pembayaranVerifikasi }}
                </h2>
                <div class="d-flex flex-column text-muted" style="font-size:.8rem; gap:4px;">
                    <span><i class="fas fa-clock text-warning mr-1"></i>Pending: <strong>{{ $pembayaranPending }}</strong></span>
                    <span><i class="fas fa-search text-info mr-1"></i>Verifikasi: <strong>{{ $pembayaranVerifikasi }}</strong></span>
                    <span><i class="fas fa-times-circle text-danger mr-1"></i>Ditolak: <strong>{{ $pembayaranDitolak }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Pendapatan --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card-revenue">
            <div>
                <p style="font-size:.68rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; opacity:.75; margin-bottom:6px;">
                    Total Pendapatan
                </p>
                <h2 style="font-size:1.45rem; font-weight:700; line-height:1.2; margin-bottom:12px; position:relative; z-index:1;">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </h2>
                <p style="font-size:.78rem; opacity:.85; margin-bottom:4px;">
                    <i class="fas fa-calendar-check mr-1"></i>Bulan ini:
                    <strong>Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</strong>
                </p>
                <p style="font-size:.73rem; opacity:.65; margin-bottom:0;">
                    <i class="fas fa-check-circle mr-1"></i>{{ $pembayaranDiterima }} pembayaran diterima
                </p>
            </div>
            <div style="position:relative; z-index:1; margin-top:16px;">
                <a href="{{ route('admin.pembayaran.index') }}" style="color:rgba(255,255,255,.8); font-size:.76rem; font-weight:600; text-decoration:none;">
                    Lihat laporan &rarr;
                </a>
            </div>
        </div>
    </div>

</div>{{-- /row 2 --}}


{{-- ══════════════════════════════════════════
 ROW 3 — Tabel Pendaftaran Terbaru + Jadwal Keberangkatan
══════════════════════════════════════════ --}}
<div class="row">

    {{-- Tabel Pendaftaran Terbaru --}}
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-user-plus text-primary mr-2" style="font-size:13px;"></i>Pendaftaran Terbaru</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($pendaftaranTerbaru->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2 d-block" style="opacity:.2;"></i>
                        <p class="mb-0" style="font-size:12px;">Belum ada data pendaftaran</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Jamaah</th>
                                    <th>Jenis</th>
                                    <th>Paket</th>
                                    <th>Status</th>
                                    <th>Tgl. Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftaranTerbaru as $daftar)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-init mr-2">
                                                    {{ strtoupper(substr($daftar->jamaah->nama_lengkap ?? 'J', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight:600; font-size:12.5px; color:#1a1d2e;">
                                                        {{ $daftar->jamaah->nama_lengkap ?? '-' }}
                                                    </div>
                                                    <small class="text-muted">{{ $daftar->jamaah->no_telepon ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                [$jColor, $jLabel] = match ($daftar->jenis) {
                                                    'haji'        => ['warning',   'Haji'],
                                                    'haji_plus'   => ['warning',   'Haji Plus'],
                                                    'haji_furoda' => ['danger',    'Furoda'],
                                                    'umroh'       => ['info',      'Umroh'],
                                                    default       => ['secondary', ucfirst($daftar->jenis)],
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $jColor }}">{{ $jLabel }}</span>
                                        </td>
                                        <td>
                                            <span style="font-weight:600; font-size:12px; color:#1a1d2e;">
                                                {{ optional(optional($daftar->keberangkatan)->paket)->nama_paket ?? '-' }}
                                            </span><br>
                                            <small class="text-muted">
                                                {{ optional($daftar->keberangkatan)->kode_keberangkatan ?? '-' }}
                                            </small>
                                        </td>
                                        <td>
                                            @php
                                                $stColor = match ($daftar->status ?? 'draft') {
                                                    'lunas'       => 'success',
                                                    'dp_terbayar' => 'primary',
                                                    'draft'       => 'secondary',
                                                    'batal'       => 'danger',
                                                    'refund'      => 'dark',
                                                    'selesai'     => 'info',
                                                    default       => 'light',
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $stColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $daftar->status ?? 'draft')) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($daftar->tanggal_daftar ?? $daftar->created_at)->format('d M Y') }}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Jadwal Keberangkatan Mendatang --}}
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-plane-departure text-success mr-2" style="font-size:13px;"></i>Keberangkatan Mendatang</h4>
            </div>
            <div class="card-body" style="padding: 6px 18px 14px;">
                @if ($keberangkatanMendatang->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-calendar-times fa-2x mb-2 d-block" style="opacity:.2;"></i>
                        <small style="font-size:12px;">Tidak ada jadwal mendatang</small>
                    </div>
                @else
                    @foreach ($keberangkatanMendatang as $kb)
                        @php
                            $hariLagi = \Carbon\Carbon::today()->diffInDays(
                                \Carbon\Carbon::parse($kb->tanggal_berangkat), false
                            );
                            $daysBadgeClass = $hariLagi <= 7
                                ? 'badge-danger'
                                : ($hariLagi <= 30 ? 'badge-warning' : 'badge-secondary');
                            $statusBadgeClass = match($kb->status) {
                                'open'      => 'badge-success',
                                'closed'    => 'badge-warning',
                                'berangkat' => 'badge-primary',
                                default     => 'badge-secondary',
                            };
                        @endphp
                        <div class="kb-item">
                            <div class="kb-date">
                                <div class="day">{{ \Carbon\Carbon::parse($kb->tanggal_berangkat)->format('d') }}</div>
                                <div class="mon">{{ \Carbon\Carbon::parse($kb->tanggal_berangkat)->translatedFormat('M') }}</div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div style="font-weight:600; font-size:.83rem; color:#1a1d2e; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ optional($kb->paket)->nama_paket ?? ($kb->kode_keberangkatan ?? '-') }}
                                </div>
                                <small class="text-muted" style="font-size:11px;">
                                    <i class="fas fa-chair mr-1"></i>Kuota: {{ $kb->kuota }}
                                    &nbsp;&bull;&nbsp;
                                    <span class="badge {{ $statusBadgeClass }}" style="font-size:.6rem;">
                                        {{ ucfirst($kb->status) }}
                                    </span>
                                </small>
                            </div>
                            <span class="badge {{ $daysBadgeClass }}" style="white-space:nowrap; flex-shrink:0;">
                                {{ $hariLagi }}h
                            </span>
                        </div>
                    @endforeach
                @endif
                <div class="text-right mt-3">
                    <a href="{{ route('admin.keberangkatan.index') }}" style="font-size:11px; color:#3b5bdb; font-weight:500; text-decoration:none;">
                        Lihat semua &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>{{-- /row 3 --}}


{{-- ══════════════════════════════════════════
 ROW 4 — Grafik 6 Bulan
══════════════════════════════════════════ --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-chart-bar text-primary mr-2" style="font-size:13px;"></i>Grafik Pendaftaran Jamaah — 6 Bulan Terakhir</h4>
                <div class="card-header-action d-flex align-items-center" style="gap:8px;">
                    <span class="badge badge-warning">
                        <i class="fas fa-square mr-1"></i>Haji
                    </span>
                    <span class="badge badge-success">
                        <i class="fas fa-square mr-1"></i>Umroh
                    </span>
                </div>
            </div>
            <div class="card-body">
                <canvas id="chartPendaftaran" height="80"></canvas>
            </div>
        </div>
    </div>
</div>{{-- /row 4 --}}

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const grafik    = @json($grafikPendaftaran);
        const labels    = grafik.map(d => d.bulan);
        const dataHaji  = grafik.map(d => d.haji);
        const dataUmroh = grafik.map(d => d.umroh);

        new Chart(document.getElementById('chartPendaftaran').getContext('2d'), {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Haji',
                        data: dataHaji,
                        backgroundColor: 'rgba(245,166,35,.75)',
                        borderColor: '#f5a623',
                        borderWidth: 1.5,
                        borderRadius: 4,
                        borderSkipped: false,
                    },
                    {
                        label: 'Umroh',
                        data: dataUmroh,
                        backgroundColor: 'rgba(39,174,96,.7)',
                        borderColor: '#27ae60',
                        borderWidth: 1.5,
                        borderRadius: 4,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1a1d2e',
                        bodyColor: '#9499b0',
                        borderColor: '#eceef5',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 5,
                        callbacks: {
                            label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y} pendaftar`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 }, color: '#9499b0' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f8' },
                        ticks: { precision: 0, color: '#9499b0', font: { size: 11 } }
                    }
                }
            }
        });
    });
</script>
@endpush
