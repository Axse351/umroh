@extends('layouts.app')

@section('title', 'Laporan Tabungan')

@section('content')
    <div class="container-fluid px-4 py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h4 class="fw-bold mb-0">Laporan Tabungan</h4>
                <small class="text-muted">Data tabungan jamaah</small>
            </div>
        </div>

        {{-- Filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan.tabungan') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Jenis Tabungan</label>
                        <select name="jenis" class="form-select">
                            <option value="">Semua</option>
                            <option value="umroh" {{ $jenis == 'umroh' ? 'selected' : '' }}>Umroh</option>
                            <option value="haji" {{ $jenis == 'haji' ? 'selected' : '' }}>Haji</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter me-1"></i> Tampilkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Rekap --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-info bg-opacity-10">
                    <div class="card-body">
                        <small class="text-muted d-block">Total Tabungan</small>
                        <h5 class="fw-bold text-info mb-0">
                            Rp {{ number_format($rekap['total'] ?? 0, 0, ',', '.') }}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-primary bg-opacity-10">
                    <div class="card-body">
                        <small class="text-muted d-block">Jumlah Nasabah</small>
                        <h5 class="fw-bold text-primary mb-0">{{ $rekap['jumlah'] ?? 0 }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-success bg-opacity-10">
                    <div class="card-body">
                        <small class="text-muted d-block">Rata-rata Saldo</small>
                        <h5 class="fw-bold text-success mb-0">
                            Rp {{ number_format($rekap['rata_rata'] ?? 0, 0, ',', '.') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="card shadow-sm">
            <div class="card-header fw-semibold bg-white border-bottom">
                <i class="bi bi-piggy-bank me-2 text-info"></i>Detail Tabungan
                <span class="badge bg-secondary ms-2">{{ $tabungans->count() }} data</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-3">#</th>
                                <th>No. Tabungan</th>
                                <th>Jamaah</th>
                                <th>Jenis</th>
                                <th>Saldo</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tabungans as $i => $item)
                                <tr>
                                    <td class="px-3 text-muted small">{{ $i + 1 }}</td>
                                    <td><span class="font-monospace small">{{ $item->no_tabungan ?? '-' }}</span></td>
                                    <td>{{ $item->jamaah->nama_lengkap ?? '-' }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($item->jenis ?? '-') }}</span></td>
                                    <td class="fw-semibold">Rp {{ number_format($item->saldo ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        @php $badge = ['aktif'=>'success','tutup'=>'secondary','cairkan'=>'warning'][$item->status ?? ''] ?? 'secondary'; @endphp
                                        <span
                                            class="badge bg-{{ $badge }}">{{ ucfirst($item->status ?? '-') }}</span>
                                    </td>
                                    <td class="small text-muted">{{ $item->created_at->isoFormat('D MMM Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Tidak ada data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
