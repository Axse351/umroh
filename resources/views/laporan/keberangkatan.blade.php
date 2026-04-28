@extends('layouts.app')

@section('title', 'Laporan Keberangkatan')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Laporan Keberangkatan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></div>
                <div class="breadcrumb-item active">Keberangkatan</div>
            </div>
        </div>

        <div class="section-body">

            {{-- Filter --}}
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-filter mr-1"></i> Filter</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.laporan.keberangkatan') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-control">
                                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
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
            @php
                $totalJamaah = $keberangkatans->sum(fn($k) => $k->pendaftarans->count());
            @endphp
            <div class="row">
                @php
                    $rekapItems = [
                        [
                            'label' => 'Total Keberangkatan',
                            'value' => $keberangkatans->count(),
                            'color' => 'bg-primary',
                            'icon' => 'fas fa-plane-departure',
                        ],
                        [
                            'label' => 'Total Jamaah Berangkat',
                            'value' => $totalJamaah,
                            'color' => 'bg-success',
                            'icon' => 'fas fa-users',
                        ],
                        [
                            'label' => 'Tahun Ditampilkan',
                            'value' => $tahun,
                            'color' => 'bg-warning',
                            'icon' => 'fas fa-calendar-alt',
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
                                <div class="card-body">{{ $r['value'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tabel --}}
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-list mr-1"></i> Detail Keberangkatan {{ $tahun }}</h4>
                    <div class="card-header-action">
                        <span class="badge badge-primary">{{ $keberangkatans->count() }} data</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Paket</th>
                                    <th>Tanggal Berangkat</th>
                                    <th>Tanggal Pulang</th>
                                    <th>Kuota</th>
                                    <th class="text-center">Jamaah Terdaftar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($keberangkatans as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><code>{{ $item->kode_keberangkatan }}</code></td>
                                        <td>{{ $item->paket->nama_paket ?? '-' }}</td>
                                        <td>{{ $item->tanggal_berangkat?->isoFormat('D MMM Y') ?? '-' }}</td>
                                        <td>{{ $item->tanggal_pulang?->isoFormat('D MMM Y') ?? '-' }}</td>
                                        <td>{{ $item->kuota }}</td>
                                        <td class="text-center">
                                            <div class="badge badge-primary">{{ $item->pendaftarans->count() }}</div>
                                        </td>
                                        <td>
                                            @php
                                                $badge =
                                                    [
                                                        'open' => 'success',
                                                        'closed' => 'secondary',
                                                        'berangkat' => 'primary',
                                                        'selesai' => 'info',
                                                        'batal' => 'danger',
                                                    ][$item->status] ?? 'secondary';
                                            @endphp
                                            <div class="badge badge-{{ $badge }}">
                                                {{ ucfirst($item->status) }}
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Sub-baris daftar jamaah --}}
                                    @if ($item->pendaftarans->count())
                                        <tr class="bg-light">
                                            <td colspan="8" class="px-5 py-2">
                                                <small class="font-weight-bold text-muted">
                                                    <i class="fas fa-users mr-1"></i> Daftar Jamaah:
                                                </small>
                                                <div class="mt-1">
                                                    @foreach ($item->pendaftarans as $p)
                                                        <span class="badge badge-light border mr-1 mb-1 text-dark">
                                                            {{ $p->jamaah->nama_lengkap ?? '-' }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                            Tidak ada keberangkatan di tahun {{ $tahun }}.
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
