@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('breadcrumb')
    <div class="breadcrumb-item active">Dashboard</div>
@endsection

@push('css')
    <style>
        /* Hanya 3 tambahan kecil yang tidak ada di Stisla */
        .stat-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 3px;
            margin-top: 6px;
        }

        .kb-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f9f9f9;
        }

        .kb-item:last-child {
            border-bottom: none;
        }

        .kb-date {
            text-align: center;
            background: #f9f9f9;
            border-radius: 3px;
            padding: 6px 10px;
            min-width: 50px;
        }

        .kb-date .day {
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1;
            color: #34395e;
        }

        .kb-date .mon {
            font-size: .6rem;
            font-weight: 700;
            color: #98a6ad;
            text-transform: uppercase;
        }

        .avatar-init {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: #6777ef;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .78rem;
            flex-shrink: 0;
        }

        .card-revenue {
            background: linear-gradient(135deg, #6777ef 0%, #4f46e5 100%);
            border-radius: 3px;
            color: #fff;
            padding: 25px;
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-revenue::before {
            content: '';
            position: absolute;
            right: -20px;
            top: -20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .1);
        }

        .card-revenue::after {
            content: '';
            position: absolute;
            right: 10px;
            bottom: -35px;
            width: 85px;
            height: 85px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .07);
        }

        .icon-bell-pulse {
            animation: bellpulse 2s infinite;
        }

        @keyframes bellpulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .6;
                transform: scale(.92);
            }
        }
    </style>
@endpush

@section('content')

    {{-- ══════════════════════════════════════════
     ROW 1  —  4 card-statistic-1 utama
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
                    <div class="stat-badges px-3 pb-3">
                        <span class="badge badge-success">{{ $pendaftaranHajiAktif }} aktif</span>
                        <span class="badge badge-secondary">{{ $pendaftaranHajiSelesai }} selesai</span>
                        <span class="badge badge-danger">{{ $pendaftaranHajiBatal }} batal</span>
                    </div>
                </div>
            </div>
            <div class="text-right pr-3 pb-2" style="margin-top:-18px;">
                <a href="{{ route('admin.pendaftaran.index', ['jenis' => 'haji']) }}" style="font-size:.75rem;">
                    Lihat semua &rarr;
                </a>
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
                    <div class="stat-badges px-3 pb-3">
                        <span class="badge badge-success">{{ $pendaftaranUmrohAktif }} aktif</span>
                        <span class="badge badge-secondary">{{ $pendaftaranUmrohSelesai }} selesai</span>
                        <span class="badge badge-danger">{{ $pendaftaranUmrohBatal }} batal</span>
                    </div>
                </div>
            </div>
            <div class="text-right pr-3 pb-2" style="margin-top:-18px;">
                <a href="{{ route('admin.pendaftaran.index', ['jenis' => 'umroh']) }}" style="font-size:.75rem;">
                    Lihat semua &rarr;
                </a>
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
                    <div class="stat-badges px-3 pb-3">
                        <span class="badge badge-primary">{{ $maskapaiAktif }} aktif</span>
                        <span class="badge badge-light">{{ $totalMaskapai - $maskapaiAktif }} nonaktif</span>
                    </div>
                </div>
            </div>
            <div class="text-right pr-3 pb-2" style="margin-top:-18px;">
                <a href="{{ route('admin.maskapai.index') }}" style="font-size:.75rem;">
                    Lihat semua &rarr;
                </a>
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
                    <div class="stat-badges px-3 pb-3">
                        <span class="badge badge-info">{{ $totalUser }} user sistem</span>
                    </div>
                </div>
            </div>
            <div class="text-right pr-3 pb-2" style="margin-top:-18px;">
                <a href="{{ route('admin.jamaah.index') }}" style="font-size:.75rem;">
                    Lihat semua &rarr;
                </a>
            </div>
        </div>

    </div>{{-- /row 1 --}}


    {{-- ══════════════════════════════════════════
     ROW 2  —  Paket · Keberangkatan · Konfirmasi · Pendapatan
══════════════════════════════════════════ --}}
    <div class="row">

        {{-- Paket --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-box-open text-warning mr-2"></i>Total Paket</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.paket.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="font-weight-bold text-dark mb-2">{{ $totalPaket }}</h2>
                    <div class="d-flex justify-content-between text-muted mb-2" style="font-size:.8rem;">
                        <span><i class="fas fa-kaaba text-warning mr-1"></i>Haji:
                            <strong>{{ $paketHaji }}</strong></span>
                        <span><i class="fas fa-mosque text-success mr-1"></i>Umroh:
                            <strong>{{ $paketUmroh }}</strong></span>
                    </div>
                    <div class="progress" style="height:4px;">
                        @php $pctHaji = $totalPaket > 0 ? ($paketHaji / $totalPaket * 100) : 0; @endphp
                        <div class="progress-bar bg-warning" style="width:{{ $pctHaji }}%"></div>
                    </div>
                    <small class="text-muted">{{ $paketAktif }} aktif dari {{ $totalPaket }} total</small>
                </div>
            </div>
        </div>

        {{-- Keberangkatan --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-paper-plane text-primary mr-2"></i>Keberangkatan</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.keberangkatan.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="font-weight-bold text-dark mb-2">{{ $totalKeberangkatan }}</h2>
                    <div class="d-flex justify-content-between text-muted mb-2" style="font-size:.8rem;">
                        <span><i class="fas fa-door-open text-primary mr-1"></i>Open:
                            <strong>{{ $keberangkatanAktif }}</strong></span>
                        <span><i class="fas fa-calendar text-info mr-1"></i>Bulan ini:
                            <strong>{{ $keberangkatanBulanIni }}</strong></span>
                    </div>
                    <span class="badge badge-light" style="font-size:.72rem;">
                        <i class="fas fa-arrow-right text-primary mr-1"></i>{{ $keberangkatanMendatang->count() }} jadwal
                        mendatang
                    </span>
                </div>
            </div>
        </div>

        {{-- Konfirmasi Pembayaran --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i
                            class="fas fa-bell {{ $pembayaranPending + $pembayaranVerifikasi > 0 ? 'text-warning icon-bell-pulse' : 'text-muted' }} mr-2"></i>
                        Perlu Konfirmasi
                    </h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.pembayaran.index', ['status' => 'pending']) }}"
                            class="btn btn-warning btn-sm">Proses</a>
                    </div>
                </div>
                <div class="card-body">
                    <h2
                        class="font-weight-bold {{ $pembayaranPending + $pembayaranVerifikasi > 0 ? 'text-warning' : 'text-dark' }} mb-2">
                        {{ $pembayaranPending + $pembayaranVerifikasi }}
                    </h2>
                    <div class="d-flex flex-column text-muted" style="font-size:.8rem; gap:2px;">
                        <span><i class="fas fa-clock text-warning mr-1"></i>Pending:
                            <strong>{{ $pembayaranPending }}</strong></span>
                        <span><i class="fas fa-search text-info mr-1"></i>Verifikasi:
                            <strong>{{ $pembayaranVerifikasi }}</strong></span>
                        <span><i class="fas fa-times-circle text-danger mr-1"></i>Ditolak:
                            <strong>{{ $pembayaranDitolak }}</strong></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Pendapatan --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card-revenue">
                <div>
                    <p
                        style="font-size:.68rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; opacity:.75; margin-bottom:4px;">
                        Total Pendapatan
                    </p>
                    <h2
                        style="font-size:1.5rem; font-weight:800; line-height:1.2; position:relative; z-index:1; margin-bottom:10px;">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h2>
                    <p style="font-size:.78rem; opacity:.85; margin-bottom:4px;">
                        <i class="fas fa-calendar-check mr-1"></i>Bulan ini:
                        <strong>Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</strong>
                    </p>
                    <p style="font-size:.74rem; opacity:.7; margin-bottom:0;">
                        <i class="fas fa-check-circle mr-1"></i>{{ $pembayaranDiterima }} pembayaran diterima
                    </p>
                </div>
                <div style="position:relative; z-index:1; margin-top:16px;">
                    <a href="{{ route('admin.pembayaran.index') }}"
                        style="color:rgba(255,255,255,.85); font-size:.76rem; font-weight:600;">
                        Lihat laporan &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>{{-- /row 2 --}}


    {{-- ══════════════════════════════════════════
     ROW 3  —  Tabel Pendaftaran Terbaru + Jadwal Keberangkatan
══════════════════════════════════════════ --}}
    <div class="row">

        {{-- Tabel Pendaftaran Terbaru --}}
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user-plus text-primary mr-2"></i>Pendaftaran Terbaru</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if ($pendaftaranTerbaru->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block" style="opacity:.2;"></i>
                            <p class="mb-0">Belum ada data pendaftaran</p>
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
                                                        <div class="font-weight-600">
                                                            {{ $daftar->jamaah->nama_lengkap ?? '-' }}</div>
                                                        <small
                                                            class="text-muted">{{ $daftar->jamaah->no_telepon ?? '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    [$jColor, $jLabel] = match ($daftar->jenis) {
                                                        'haji' => ['warning', 'Haji'],
                                                        'haji_plus' => ['warning', 'Haji Plus'],
                                                        'haji_furoda' => ['danger', 'Furoda'],
                                                        'umroh' => ['info', 'Umroh'],
                                                        default => ['secondary', ucfirst($daftar->jenis)],
                                                    };
                                                @endphp
                                                <span class="badge badge-{{ $jColor }}">{{ $jLabel }}</span>
                                            </td>
                                            <td>
                                                <span class="font-weight-600" style="font-size:.83rem;">
                                                    {{ optional(optional($daftar->keberangkatan)->paket)->nama_paket ?? '-' }}
                                                </span><br>
                                                <small class="text-muted">
                                                    {{ optional($daftar->keberangkatan)->kode_keberangkatan ?? '-' }}
                                                </small>
                                            </td>
                                            <td>
                                                @php
                                                    $stColor = match ($daftar->status ?? 'draft') {
                                                        'lunas' => 'success',
                                                        'dp_terbayar' => 'primary',
                                                        'draft' => 'secondary',
                                                        'batal' => 'danger',
                                                        'refund' => 'dark',
                                                        'selesai' => 'info',
                                                        default => 'light',
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
                    <h4><i class="fas fa-plane-departure text-success mr-2"></i>Keberangkatan Mendatang</h4>
                </div>
                <div class="card-body">
                    @if ($keberangkatanMendatang->isEmpty())
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2 d-block" style="opacity:.2;"></i>
                            <small>Tidak ada jadwal mendatang</small>
                        </div>
                    @else
                        @foreach ($keberangkatanMendatang as $kb)
                            <div class="kb-item">
                                <div class="kb-date">
                                    <div class="day">{{ \Carbon\Carbon::parse($kb->tanggal_berangkat)->format('d') }}
                                    </div>
                                    <div class="mon">
                                        {{ \Carbon\Carbon::parse($kb->tanggal_berangkat)->translatedFormat('M') }}</div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="font-weight-600 text-truncate" style="font-size:.84rem; color:#34395e;">
                                        {{ optional($kb->paket)->nama_paket ?? ($kb->kode_keberangkatan ?? '-') }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-chair mr-1"></i>Kuota: {{ $kb->kuota }}
                                        &nbsp;&bull;&nbsp;
                                        <span
                                            class="badge badge-{{ match ($kb->status) {'open' => 'success','closed' => 'warning','berangkat' => 'primary',default => 'secondary'} }}"
                                            style="font-size:.62rem; padding:2px 6px;">
                                            {{ ucfirst($kb->status) }}
                                        </span>
                                    </small>
                                </div>
                                @php
                                    $hariLagi = \Carbon\Carbon::today()->diffInDays(
                                        \Carbon\Carbon::parse($kb->tanggal_berangkat),
                                        false,
                                    );
                                @endphp
                                <span
                                    class="badge {{ $hariLagi <= 7 ? 'badge-danger' : ($hariLagi <= 30 ? 'badge-warning' : 'badge-secondary') }}"
                                    style="white-space:nowrap; font-size:.68rem;">
                                    {{ $hariLagi }}h
                                </span>
                            </div>
                        @endforeach
                    @endif
                    <div class="mt-3 text-right">
                        <a href="{{ route('admin.keberangkatan.index') }}" style="font-size:.78rem;">
                            Lihat semua &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /row 3 --}}


    {{-- ══════════════════════════════════════════
     ROW 4  —  Grafik 6 Bulan
══════════════════════════════════════════ --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-bar text-primary mr-2"></i>Grafik Pendaftaran Jamaah — 6 Bulan Terakhir</h4>
                    <div class="card-header-action">
                        <span class="badge badge-warning mr-1">
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
    </div>

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
                            backgroundColor: 'rgba(255,164,38,.85)',
                            borderColor: '#ffa426',
                            borderWidth: 2,
                            borderRadius: 4,
                            borderSkipped: false,
                        },
                        {
                            label: 'Umroh',
                            data: dataUmroh,
                            backgroundColor: 'rgba(99,237,122,.85)',
                            borderColor: '#63ed7a',
                            borderWidth: 2,
                            borderRadius: 4,
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
                            titleColor: '#34395e',
                            bodyColor: '#98a6ad',
                            borderColor: '#e4e6fc',
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
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#98a6ad'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f9f9f9'
                            },
                            ticks: {
                                precision: 0,
                                color: '#98a6ad',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
