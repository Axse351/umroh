@extends('layouts.app')

@section('title', 'Laporan Jamaah')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Laporan Jamaah</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></div>
                <div class="breadcrumb-item active">Jamaah</div>
            </div>
        </div>

        <div class="section-body">

            {{-- Filter --}}
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-filter mr-1"></i> Filter</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.laporan.jamaah') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Dari</label>
                                    <input type="date" name="dari" value="{{ $dari }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sampai</label>
                                    <input type="date" name="sampai" value="{{ $sampai }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <select name="jenis" class="form-control">
                                        <option value="">Semua</option>
                                        <option value="umroh" {{ $jenis == 'umroh' ? 'selected' : '' }}>Umroh</option>
                                        <option value="haji" {{ $jenis == 'haji' ? 'selected' : '' }}>Haji</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search mr-1"></i> Tampilkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Rekap --}}
            <div class="row">
                @php
                    $rekapItems = [
                        [
                            'label' => 'Total Pendaftar',
                            'key' => 'total',
                            'color' => 'bg-primary',
                            'icon' => 'fas fa-users',
                        ],
                        [
                            'label' => 'Lunas',
                            'key' => 'lunas',
                            'color' => 'bg-success',
                            'icon' => 'fas fa-check-circle',
                        ],
                        [
                            'label' => 'DP Terbayar',
                            'key' => 'dp_terbayar',
                            'color' => 'bg-warning',
                            'icon' => 'fas fa-coins',
                        ],
                        [
                            'label' => 'Batal / Refund',
                            'key' => 'batal',
                            'color' => 'bg-danger',
                            'icon' => 'fas fa-times-circle',
                        ],
                    ];
                @endphp
                @foreach ($rekapItems as $r)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon {{ $r['color'] }}">
                                <i class="{{ $r['icon'] }}"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ $r['label'] }}</h4>
                                </div>
                                <div class="card-body">{{ $rekap[$r['key']] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tabel --}}
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-list mr-1"></i> Detail Pendaftaran</h4>
                    <div class="card-header-action">
                        <span class="badge badge-primary">{{ $pendaftarans->count() }} data</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Pendaftaran</th>
                                    <th>Jamaah</th>
                                    <th>Paket</th>
                                    <th>Tgl. Berangkat</th>
                                    <th>Tipe Kamar</th>
                                    <th>Harga Jual</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendaftarans as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><code>{{ $item->no_pendaftaran }}</code></td>
                                        <td>{{ $item->jamaah->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $item->keberangkatan->paket->nama_paket ?? '-' }}</td>
                                        <td>{{ $item->keberangkatan->tanggal_berangkat?->isoFormat('D MMM Y') ?? '-' }}
                                        </td>
                                        <td>{{ ucfirst($item->tipe_kamar ?? '-') }}</td>
                                        <td>Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $badge =
                                                    [
                                                        'lunas' => 'success',
                                                        'dp_terbayar' => 'warning',
                                                        'konfirmasi' => 'info',
                                                        'draft' => 'secondary',
                                                        'batal' => 'danger',
                                                        'refund' => 'dark',
                                                        'berangkat' => 'primary',
                                                        'selesai' => 'success',
                                                    ][$item->status] ?? 'secondary';
                                            @endphp
                                            <div class="badge badge-{{ $badge }}">
                                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i> Tidak ada data.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
