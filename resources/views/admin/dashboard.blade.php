@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('breadcrumb')
    <div class="breadcrumb-item active">Dashboard</div>
@endsection

@push('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@500&display=swap');

        /* ── Global override ── */
        body,
        .main-content,
        .section-body {
            font-family: 'DM Sans', sans-serif !important;
            background: #f4f5f9 !important;
        }

        /* ── Sidebar & Navbar ── */
        .main-sidebar {
            box-shadow: none !important;
            border-right: 1px solid #e8eaf0 !important;
        }

        .navbar-bg {
            box-shadow: none !important;
            border-bottom: 1px solid #e8eaf0 !important;
        }

        /* ══════════════════════════════════
       WRAPPER SEMUA CARD KUSTOM
    ══════════════════════════════════ */
        .db-card {
            background: #ffffff !important;
            border: 1px solid #e8eaf0 !important;
            border-radius: 12px !important;
            box-shadow: none !important;
            overflow: hidden !important;
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            /* reset stisla card */
            padding: 0 !important;
            margin-bottom: 0 !important;
        }

        /* Card dark (pendapatan) */
        .db-card-dark {
            background: #1c1e2e !important;
            border: none !important;
            border-radius: 12px !important;
            box-shadow: none !important;
            overflow: hidden !important;
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            padding: 22px !important;
            position: relative !important;
            min-height: 190px !important;
        }

        .db-card-dark::before {
            content: '';
            position: absolute;
            top: -28px;
            right: -28px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
            pointer-events: none;
        }

        /* ── Card Header ── */
        .db-card-header {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 14px 18px !important;
            border-bottom: 1px solid #f0f1f6 !important;
            flex-shrink: 0 !important;
        }

        .db-card-title {
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1c1e2e !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            margin: 0 !important;
        }

        /* ── Card Body ── */
        .db-card-body {
            padding: 18px !important;
            flex: 1 !important;
        }

        /* ══════════════════════════════════
       STAT CARD (Row 1) — ikon + angka + chip + link
    ══════════════════════════════════ */
        .sc-wrap {
            display: flex !important;
            flex-direction: column !important;
            height: 100% !important;
            padding: 18px !important;
            gap: 0 !important;
        }

        .sc-icon {
            width: 40px !important;
            height: 40px !important;
            border-radius: 10px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 15px !important;
            margin-bottom: 14px !important;
            flex-shrink: 0 !important;
        }

        .sc-icon-amber {
            background: #fff4e0 !important;
            color: #d4820a !important;
        }

        .sc-icon-green {
            background: #e8f7ee !important;
            color: #1a8a50 !important;
        }

        .sc-icon-indigo {
            background: #eceffe !important;
            color: #3a4dcc !important;
        }

        .sc-icon-rose {
            background: #fce9ec !important;
            color: #c42d45 !important;
        }

        .sc-label {
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #9499b8 !important;
            margin: 0 0 4px !important;
            text-transform: none !important;
            letter-spacing: 0 !important;
        }

        .sc-value {
            font-size: 32px !important;
            font-weight: 600 !important;
            color: #1c1e2e !important;
            line-height: 1 !important;
            margin: 0 0 12px !important;
            font-family: 'DM Mono', monospace !important;
            letter-spacing: -.5px !important;
        }

        .sc-chips {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 5px !important;
            margin-bottom: 12px !important;
        }

        .sc-footer {
            margin-top: auto !important;
            padding-top: 10px !important;
            border-top: 1px solid #f0f1f6 !important;
            text-align: right !important;
        }

        .sc-footer a {
            font-size: 11px !important;
            font-weight: 600 !important;
            color: #3a4dcc !important;
            text-decoration: none !important;
        }

        .sc-footer a:hover {
            color: #2535a8 !important;
            text-decoration: none !important;
        }

        /* ══════════════════════════════════
       CHIP / BADGE
    ══════════════════════════════════ */
        .ch {
            display: inline-flex !important;
            align-items: center !important;
            font-size: 10.5px !important;
            font-weight: 500 !important;
            padding: 3px 9px !important;
            border-radius: 20px !important;
            line-height: 1.4 !important;
            white-space: nowrap !important;
        }

        .ch-green {
            background: #e8f7ee !important;
            color: #15703f !important;
        }

        .ch-slate {
            background: #f0f1f7 !important;
            color: #5c6080 !important;
        }

        .ch-rose {
            background: #fce9ec !important;
            color: #a32439 !important;
        }

        .ch-indigo {
            background: #eceffe !important;
            color: #2d3daa !important;
        }

        .ch-sky {
            background: #e4f2fc !important;
            color: #1158a0 !important;
        }

        .ch-amber {
            background: #fff4e0 !important;
            color: #9c6008 !important;
        }

        /* ══════════════════════════════════
       MINI BTN
    ══════════════════════════════════ */
        .mbtn {
            font-size: 11px !important;
            font-weight: 600 !important;
            padding: 5px 14px !important;
            border-radius: 8px !important;
            border: none !important;
            cursor: pointer !important;
            text-decoration: none !important;
            display: inline-block !important;
            line-height: 1.5 !important;
            transition: opacity .15s !important;
        }

        .mbtn:hover {
            opacity: .82 !important;
            text-decoration: none !important;
        }

        .mbtn-indigo {
            background: #eceffe !important;
            color: #2d3daa !important;
        }

        .mbtn-amber {
            background: #fff4e0 !important;
            color: #9c6008 !important;
        }

        /* ══════════════════════════════════
       INFO CARD (Row 2) body
    ══════════════════════════════════ */
        .ic-num {
            font-size: 34px !important;
            font-weight: 600 !important;
            color: #1c1e2e !important;
            font-family: 'DM Mono', monospace !important;
            line-height: 1 !important;
            margin-bottom: 12px !important;
            letter-spacing: -.5px !important;
        }

        .ic-num-warn {
            color: #c47a0a !important;
        }

        .ic-row {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            font-size: 11.5px !important;
            color: #6b6f8c !important;
            padding: 4px 0 !important;
            border-bottom: 1px solid #f5f5fa !important;
        }

        .ic-row:last-child {
            border-bottom: none !important;
        }

        .ic-row strong {
            color: #1c1e2e !important;
            font-weight: 600 !important;
        }

        .ic-row-left {
            display: flex !important;
            align-items: center !important;
            gap: 7px !important;
        }

        .prog-wrap {
            background: #f0f1f7 !important;
            border-radius: 3px !important;
            height: 3px !important;
            margin: 10px 0 8px !important;
            overflow: hidden !important;
        }

        .prog-bar {
            height: 100% !important;
            border-radius: 3px !important;
            background: #d4820a !important;
        }

        .ic-note {
            font-size: 10.5px !important;
            color: #9499b8 !important;
        }

        /* ══════════════════════════════════
       PENDAPATAN (dark card)
    ══════════════════════════════════ */
        .rev-label {
            font-size: 9.5px !important;
            font-weight: 600 !important;
            letter-spacing: 1.2px !important;
            text-transform: uppercase !important;
            color: rgba(255, 255, 255, .4) !important;
            margin-bottom: 10px !important;
        }

        .rev-amount {
            font-size: 1.55rem !important;
            font-weight: 600 !important;
            color: #fff !important;
            font-family: 'DM Mono', monospace !important;
            line-height: 1.2 !important;
            margin-bottom: 16px !important;
            position: relative !important;
            z-index: 1 !important;
        }

        .rev-row {
            display: flex !important;
            align-items: center !important;
            gap: 7px !important;
            font-size: 11.5px !important;
            color: rgba(255, 255, 255, .5) !important;
            margin-bottom: 6px !important;
        }

        .rev-row strong {
            color: rgba(255, 255, 255, .85) !important;
            font-weight: 500 !important;
        }

        .rev-link {
            font-size: 11px !important;
            font-weight: 600 !important;
            color: rgba(255, 255, 255, .38) !important;
            text-decoration: none !important;
            transition: color .15s !important;
            position: relative !important;
            z-index: 1 !important;
        }

        .rev-link:hover {
            color: rgba(255, 255, 255, .75) !important;
            text-decoration: none !important;
        }

        /* ══════════════════════════════════
       TABLE
    ══════════════════════════════════ */
        .db-table thead th {
            font-size: 10px !important;
            font-weight: 600 !important;
            color: #9499b8 !important;
            text-transform: uppercase !important;
            letter-spacing: .6px !important;
            padding: 10px 16px !important;
            background: #f8f9fd !important;
            border-bottom: 1px solid #f0f1f6 !important;
            border-top: none !important;
            white-space: nowrap !important;
        }

        .db-table tbody td {
            font-size: 12px !important;
            color: #4a4e6a !important;
            padding: 11px 16px !important;
            vertical-align: middle !important;
            border-color: #f5f5fa !important;
        }

        .db-table tbody tr:hover td {
            background: #fafbff !important;
        }

        .av {
            width: 30px !important;
            height: 30px !important;
            border-radius: 50% !important;
            background: #eceffe !important;
            color: #3a4dcc !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: 700 !important;
            font-size: 11px !important;
            flex-shrink: 0 !important;
        }

        /* ══════════════════════════════════
       KEBERANGKATAN MENDATANG
    ══════════════════════════════════ */
        .kb-list {
            padding: 4px 18px 8px !important;
            flex: 1 !important;
        }

        .kb-item {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 11px 0 !important;
            border-bottom: 1px solid #f5f5fa !important;
        }

        .kb-item:last-child {
            border-bottom: none !important;
        }

        .kb-datebox {
            background: #f4f5f9 !important;
            border-radius: 9px !important;
            padding: 8px 10px !important;
            text-align: center !important;
            min-width: 44px !important;
            flex-shrink: 0 !important;
        }

        .kb-datebox .d {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #1c1e2e !important;
            line-height: 1 !important;
            font-family: 'DM Mono', monospace !important;
        }

        .kb-datebox .m {
            font-size: 9px !important;
            font-weight: 600 !important;
            color: #9499b8 !important;
            text-transform: uppercase !important;
            margin-top: 1px !important;
        }

        .kb-name {
            font-size: 12.5px !important;
            font-weight: 600 !important;
            color: #1c1e2e !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            margin-bottom: 3px !important;
        }

        .kb-meta {
            font-size: 10.5px !important;
            color: #9499b8 !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .kb-days {
            font-size: 10px !important;
            font-weight: 700 !important;
            padding: 3px 8px !important;
            border-radius: 20px !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
            font-family: 'DM Mono', monospace !important;
        }

        .kb-soon {
            background: #fce9ec !important;
            color: #a32439 !important;
        }

        .kb-mid {
            background: #fff4e0 !important;
            color: #9c6008 !important;
        }

        .kb-normal {
            background: #f0f1f7 !important;
            color: #5c6080 !important;
        }

        .kb-footer {
            padding: 10px 18px !important;
            border-top: 1px solid #f0f1f6 !important;
            text-align: right !important;
            flex-shrink: 0 !important;
        }

        .kb-footer a {
            font-size: 11px !important;
            font-weight: 600 !important;
            color: #3a4dcc !important;
            text-decoration: none !important;
        }

        /* ══════════════════════════════════
       CHART CARD
    ══════════════════════════════════ */
        .chart-legend {
            display: flex !important;
            gap: 14px !important;
            align-items: center !important;
        }

        .leg {
            display: flex !important;
            align-items: center !important;
            gap: 5px !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6b6f8c !important;
        }

        .leg-dot {
            width: 8px !important;
            height: 8px !important;
            border-radius: 50% !important;
            display: inline-block !important;
        }

        /* ── Pulse ── */
        .pulse {
            animation: bp 2s infinite !important;
        }

        @keyframes bp {

            0%,
            100% {
                opacity: 1;
                transform: scale(1)
            }

            50% {
                opacity: .4;
                transform: scale(.88)
            }
        }

        /* ── Empty state ── */
        .empty-st {
            text-align: center !important;
            padding: 36px 20px !important;
            color: #c0c3d8 !important;
        }

        .empty-st i {
            font-size: 26px !important;
            display: block !important;
            margin-bottom: 8px !important;
        }

        .empty-st p {
            font-size: 11.5px !important;
            margin: 0 !important;
        }

        /* ── Row gap ── */
        .row-gap {
            margin-bottom: 20px !important;
        }
    </style>
@endpush

@section('content')

    {{-- ══════════════════════════════════════
 ROW 1 — 4 stat cards
══════════════════════════════════════ --}}
    <div class="row row-gap">

        {{-- Haji --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="padding-bottom:16px;">
            <div class="db-card">
                <div class="sc-wrap">
                    <div class="sc-icon sc-icon-amber"><i class="fas fa-kaaba"></i></div>
                    <p class="sc-label">Pendaftaran Haji</p>
                    <p class="sc-value">{{ number_format($totalPendaftaranHaji) }}</p>
                    <div class="sc-chips">
                        <span class="ch ch-green">{{ $pendaftaranHajiAktif }} aktif</span>
                        <span class="ch ch-slate">{{ $pendaftaranHajiSelesai }} selesai</span>
                        <span class="ch ch-rose">{{ $pendaftaranHajiBatal }} batal</span>
                    </div>
                    <div class="sc-footer">
                        <a href="{{ route('admin.pendaftaran.index', ['jenis' => 'haji']) }}">Lihat semua →</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Umroh --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="padding-bottom:16px;">
            <div class="db-card">
                <div class="sc-wrap">
                    <div class="sc-icon sc-icon-green"><i class="fas fa-mosque"></i></div>
                    <p class="sc-label">Pendaftaran Umroh</p>
                    <p class="sc-value">{{ number_format($totalPendaftaranUmroh) }}</p>
                    <div class="sc-chips">
                        <span class="ch ch-green">{{ $pendaftaranUmrohAktif }} aktif</span>
                        <span class="ch ch-slate">{{ $pendaftaranUmrohSelesai }} selesai</span>
                        <span class="ch ch-rose">{{ $pendaftaranUmrohBatal }} batal</span>
                    </div>
                    <div class="sc-footer">
                        <a href="{{ route('admin.pendaftaran.index', ['jenis' => 'umroh']) }}">Lihat semua →</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Maskapai --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="padding-bottom:16px;">
            <div class="db-card">
                <div class="sc-wrap">
                    <div class="sc-icon sc-icon-indigo"><i class="fas fa-plane"></i></div>
                    <p class="sc-label">Total Maskapai</p>
                    <p class="sc-value">{{ number_format($totalMaskapai) }}</p>
                    <div class="sc-chips">
                        <span class="ch ch-indigo">{{ $maskapaiAktif }} aktif</span>
                        <span class="ch ch-slate">{{ $totalMaskapai - $maskapaiAktif }} nonaktif</span>
                    </div>
                    <div class="sc-footer">
                        <a href="{{ route('admin.maskapai.index') }}">Lihat semua →</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jamaah --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="padding-bottom:16px;">
            <div class="db-card">
                <div class="sc-wrap">
                    <div class="sc-icon sc-icon-rose"><i class="fas fa-users"></i></div>
                    <p class="sc-label">Data Jamaah</p>
                    <p class="sc-value">{{ number_format($totalJamaah) }}</p>
                    <div class="sc-chips">
                        <span class="ch ch-sky">{{ $totalUser }} user sistem</span>
                    </div>
                    <div class="sc-footer">
                        <a href="{{ route('admin.jamaah.index') }}">Lihat semua →</a>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /row 1 --}}


    {{-- ══════════════════════════════════════
 ROW 2 — Paket · Keberangkatan · Konfirmasi · Pendapatan
══════════════════════════════════════ --}}
    <div class="row row-gap">

        {{-- Paket --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="padding-bottom:16px;">
            <div class="db-card">
                <div class="db-card-header">
                    <p class="db-card-title">
                        <i class="fas fa-box-open" style="color:#d4820a; font-size:12px;"></i>
                        Total Paket
                    </p>
                    <a href="{{ route('admin.paket.index') }}" class="mbtn mbtn-indigo">Kelola</a>
                </div>
                <div class="db-card-body">
                    <div class="ic-num">{{ $totalPaket }}</div>
                    <div class="ic-row">
                        <span class="ic-row-left"><i class="fas fa-kaaba"
                                style="color:#d4820a; font-size:11px;"></i>Haji</span>
                        <strong>{{ $paketHaji }}</strong>
                    </div>
                    <div class="ic-row">
                        <span class="ic-row-left"><i class="fas fa-mosque"
                                style="color:#1a8a50; font-size:11px;"></i>Umroh</span>
                        <strong>{{ $paketUmroh }}</strong>
                    </div>
                    @php $pctHaji = $totalPaket > 0 ? ($paketHaji / $totalPaket * 100) : 0; @endphp
                    <div class="prog-wrap">
                        <div class="prog-bar" style="width:{{ $pctHaji }}%"></div>
                    </div>
                    <p class="ic-note">{{ $paketAktif }} aktif dari {{ $totalPaket }} total</p>
                </div>
            </div>
        </div>

        {{-- Keberangkatan --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="padding-bottom:16px;">
            <div class="db-card">
                <div class="db-card-header">
                    <p class="db-card-title">
                        <i class="fas fa-paper-plane" style="color:#3a4dcc; font-size:12px;"></i>
                        Keberangkatan
                    </p>
                    <a href="{{ route('admin.keberangkatan.index') }}" class="mbtn mbtn-indigo">Kelola</a>
                </div>
                <div class="db-card-body">
                    <div class="ic-num">{{ $totalKeberangkatan }}</div>
                    <div class="ic-row">
                        <span class="ic-row-left"><i class="fas fa-door-open"
                                style="color:#3a4dcc; font-size:11px;"></i>Open</span>
                        <strong>{{ $keberangkatanAktif }}</strong>
                    </div>
                    <div class="ic-row">
                        <span class="ic-row-left"><i class="fas fa-calendar"
                                style="color:#1158a0; font-size:11px;"></i>Bulan ini</span>
                        <strong>{{ $keberangkatanBulanIni }}</strong>
                    </div>
                    <div style="margin-top:12px;">
                        <span class="ch ch-indigo">
                            <i class="fas fa-arrow-right" style="font-size:9px; margin-right:4px;"></i>
                            {{ $keberangkatanMendatang->count() }} jadwal mendatang
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Konfirmasi --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="padding-bottom:16px;">
            <div class="db-card">
                <div class="db-card-header">
                    <p class="db-card-title">
                        <i class="fas fa-bell {{ $pembayaranPending + $pembayaranVerifikasi > 0 ? 'pulse' : '' }}"
                            style="color:{{ $pembayaranPending + $pembayaranVerifikasi > 0 ? '#c47a0a' : '#9499b8' }}; font-size:12px;"></i>
                        Perlu Konfirmasi
                    </p>
                    <a href="{{ route('admin.pembayaran.index', ['status' => 'pending']) }}"
                        class="mbtn mbtn-amber">Proses</a>
                </div>
                <div class="db-card-body">
                    <div class="ic-num {{ $pembayaranPending + $pembayaranVerifikasi > 0 ? 'ic-num-warn' : '' }}">
                        {{ $pembayaranPending + $pembayaranVerifikasi }}
                    </div>
                    <div class="ic-row">
                        <span class="ic-row-left"><i class="fas fa-clock"
                                style="color:#c47a0a; font-size:11px;"></i>Pending</span>
                        <strong>{{ $pembayaranPending }}</strong>
                    </div>
                    <div class="ic-row">
                        <span class="ic-row-left"><i class="fas fa-search"
                                style="color:#1158a0; font-size:11px;"></i>Verifikasi</span>
                        <strong>{{ $pembayaranVerifikasi }}</strong>
                    </div>
                    <div class="ic-row">
                        <span class="ic-row-left"><i class="fas fa-times-circle"
                                style="color:#c42d45; font-size:11px;"></i>Ditolak</span>
                        <strong>{{ $pembayaranDitolak }}</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pendapatan --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" style="padding-bottom:16px;">
            <div class="db-card-dark">
                <div>
                    <div class="rev-label">Total Pendapatan</div>
                    <div class="rev-amount">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="rev-row">
                        <i class="fas fa-calendar-check" style="font-size:10px;"></i>
                        Bulan ini: <strong>Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</strong>
                    </div>
                    <div class="rev-row">
                        <i class="fas fa-check-circle" style="font-size:10px;"></i>
                        <strong>{{ $pembayaranDiterima }}</strong>&nbsp;pembayaran diterima
                    </div>
                </div>
                <a href="{{ route('admin.pembayaran.index') }}" class="rev-link">Lihat laporan →</a>
            </div>
        </div>

    </div>{{-- /row 2 --}}


    {{-- ══════════════════════════════════════
 ROW 3 — Tabel + Keberangkatan Mendatang
══════════════════════════════════════ --}}
    <div class="row row-gap">

        {{-- Tabel Pendaftaran Terbaru --}}
        <div class="col-lg-8 col-md-12" style="padding-bottom:16px;">
            <div class="db-card">
                <div class="db-card-header">
                    <p class="db-card-title">
                        <i class="fas fa-user-plus" style="color:#3a4dcc; font-size:12px;"></i>
                        Pendaftaran Terbaru
                    </p>
                    <a href="{{ route('admin.pendaftaran.index') }}" class="mbtn mbtn-indigo">Lihat Semua</a>
                </div>

                @if ($pendaftaranTerbaru->isEmpty())
                    <div class="empty-st">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada data pendaftaran</p>
                    </div>
                @else
                    <div class="table-responsive" style="flex:1;">
                        <table class="table table-hover mb-0 db-table">
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
                                            <div style="display:flex; align-items:center; gap:10px;">
                                                <div class="av">
                                                    {{ strtoupper(substr($daftar->jamaah->nama_lengkap ?? 'J', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight:600; font-size:12px; color:#1c1e2e;">
                                                        {{ $daftar->jamaah->nama_lengkap ?? '-' }}</div>
                                                    <div style="font-size:10.5px; color:#9499b8;">
                                                        {{ $daftar->jamaah->no_telepon ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                [$jc, $jl] = match ($daftar->jenis) {
                                                    'haji' => ['ch-amber', 'Haji'],
                                                    'haji_plus' => ['ch-amber', 'Haji Plus'],
                                                    'haji_furoda' => ['ch-rose', 'Furoda'],
                                                    'umroh' => ['ch-sky', 'Umroh'],
                                                    default => ['ch-slate', ucfirst($daftar->jenis)],
                                                };
                                            @endphp
                                            <span class="ch {{ $jc }}">{{ $jl }}</span>
                                        </td>
                                        <td>
                                            <div style="font-weight:600; font-size:11.5px; color:#1c1e2e;">
                                                {{ optional(optional($daftar->keberangkatan)->paket)->nama_paket ?? '-' }}
                                            </div>
                                            <div style="font-size:10.5px; color:#9499b8;">
                                                {{ optional($daftar->keberangkatan)->kode_keberangkatan ?? '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $sc = match ($daftar->status ?? 'draft') {
                                                    'lunas' => 'ch-green',
                                                    'dp_terbayar' => 'ch-indigo',
                                                    'draft' => 'ch-slate',
                                                    'batal' => 'ch-rose',
                                                    'refund' => 'ch-slate',
                                                    'selesai' => 'ch-sky',
                                                    default => 'ch-slate',
                                                };
                                            @endphp
                                            <span class="ch {{ $sc }}">
                                                {{ ucfirst(str_replace('_', ' ', $daftar->status ?? 'draft')) }}
                                            </span>
                                        </td>
                                        <td style="font-size:11px; color:#9499b8;">
                                            {{ \Carbon\Carbon::parse($daftar->tanggal_daftar ?? $daftar->created_at)->format('d M Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Jadwal Keberangkatan Mendatang --}}
        <div class="col-lg-4 col-md-12" style="padding-bottom:16px;">
            <div class="db-card">
                <div class="db-card-header">
                    <p class="db-card-title">
                        <i class="fas fa-plane-departure" style="color:#1a8a50; font-size:12px;"></i>
                        Keberangkatan Mendatang
                    </p>
                </div>

                <div class="kb-list">
                    @if ($keberangkatanMendatang->isEmpty())
                        <div class="empty-st">
                            <i class="fas fa-calendar-times"></i>
                            <p>Tidak ada jadwal mendatang</p>
                        </div>
                    @else
                        @foreach ($keberangkatanMendatang as $kb)
                            @php
                                $hl = \Carbon\Carbon::today()->diffInDays(
                                    \Carbon\Carbon::parse($kb->tanggal_berangkat),
                                    false,
                                );
                                $dc = $hl <= 7 ? 'kb-soon' : ($hl <= 30 ? 'kb-mid' : 'kb-normal');
                                $sc2 = match ($kb->status) {
                                    'open' => 'ch-green',
                                    'closed' => 'ch-amber',
                                    'berangkat' => 'ch-indigo',
                                    default => 'ch-slate',
                                };
                            @endphp
                            <div class="kb-item">
                                <div class="kb-datebox">
                                    <div class="d">{{ \Carbon\Carbon::parse($kb->tanggal_berangkat)->format('d') }}
                                    </div>
                                    <div class="m">
                                        {{ \Carbon\Carbon::parse($kb->tanggal_berangkat)->translatedFormat('M') }}</div>
                                </div>
                                <div style="flex:1; overflow:hidden;">
                                    <div class="kb-name">
                                        {{ optional($kb->paket)->nama_paket ?? ($kb->kode_keberangkatan ?? '-') }}</div>
                                    <div class="kb-meta">
                                        <i class="fas fa-chair" style="font-size:9px;"></i>{{ $kb->kuota }}
                                        <span class="ch {{ $sc2 }}"
                                            style="font-size:9px; padding:2px 7px;">{{ ucfirst($kb->status) }}</span>
                                    </div>
                                </div>
                                <span class="kb-days {{ $dc }}">{{ $hl }}h</span>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="kb-footer">
                    <a href="{{ route('admin.keberangkatan.index') }}">Lihat semua →</a>
                </div>
            </div>
        </div>

    </div>{{-- /row 3 --}}


    {{-- ══════════════════════════════════════
 ROW 4 — Grafik 6 Bulan
══════════════════════════════════════ --}}
    <div class="row">
        <div class="col-12" style="padding-bottom:16px;">
            <div class="db-card">
                <div class="db-card-header">
                    <p class="db-card-title">
                        <i class="fas fa-chart-bar" style="color:#3a4dcc; font-size:12px;"></i>
                        Grafik Pendaftaran Jamaah — 6 Bulan Terakhir
                    </p>
                    <div class="chart-legend">
                        <span class="leg"><span class="leg-dot" style="background:#d4820a;"></span>Haji</span>
                        <span class="leg"><span class="leg-dot" style="background:#1a8a50;"></span>Umroh</span>
                    </div>
                </div>
                <div style="padding:20px 20px 16px;">
                    <canvas id="chartPendaftaran" style="max-height:260px;"></canvas>
                </div>
            </div>
        </div>
    </div>{{-- /row 4 --}}

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const grafik = @json($grafikPendaftaran);
            const labels = grafik.map(d => d.bulan);
            const dataHaji = grafik.map(d => d.haji);
            const dataUmroh = grafik.map(d => d.umroh);

            new Chart(document.getElementById('chartPendaftaran').getContext('2d'), {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                            label: 'Haji',
                            data: dataHaji,
                            backgroundColor: 'rgba(212,130,10,.12)',
                            borderColor: '#d4820a',
                            borderWidth: 1.5,
                            borderRadius: 5,
                            borderSkipped: false,
                        },
                        {
                            label: 'Umroh',
                            data: dataUmroh,
                            backgroundColor: 'rgba(26,138,80,.12)',
                            borderColor: '#1a8a50',
                            borderWidth: 1.5,
                            borderRadius: 5,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#1c1e2e',
                            bodyColor: '#6b6f8c',
                            borderColor: '#e8eaf0',
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
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11,
                                    family: 'DM Sans'
                                },
                                color: '#9499b8'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f0f1f7'
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                precision: 0,
                                color: '#9499b8',
                                font: {
                                    size: 11,
                                    family: 'DM Sans'
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
