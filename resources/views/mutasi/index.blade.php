@extends('layouts.app')

@section('title', 'Mutasi Pembayaran')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Mutasi Pembayaran</h4>
            <small class="text-muted">Riwayat transaksi pembayaran per jamaah</small>
        </div>
    </div>

    {{-- Search --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('admin.mutasi.index') }}" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama / no. identitas jamaah..." value="{{ $search }}">
                <button class="btn btn-sm btn-primary px-3">
                    <i class="bi bi-search"></i>
                </button>
                @if($search)
                    <a href="{{ route('admin.mutasi.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">#</th>
                            <th>Nama Jamaah</th>
                            <th>No. Identitas</th>
                            <th>Jumlah Pendaftaran</th>
                            <th>Total Terbayar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jamaahs as $jamaah)
                            @php
                                $terbayar = $jamaah->pendaftarans
                                    ->flatMap->pembayarans
                                    ->where('status', 'diterima')
                                    ->sum('jumlah_bayar');
                            @endphp
                            <tr>
                                <td class="px-3 text-muted small">{{ $jamaahs->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $jamaah->nama_lengkap }}</td>
                                <td class="font-monospace small text-muted">{{ $jamaah->no_identitas ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $jamaah->pendaftarans_count }} Pendaftaran</span>
                                </td>
                                <td class="fw-semibold text-success">
                                    Rp {{ number_format($terbayar, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('admin.mutasi.show', $jamaah) }}"
                                            class="btn btn-sm btn-outline-info" title="Detail Mutasi">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.mutasi.cetak', $jamaah) }}"
                                            class="btn btn-sm btn-outline-dark" title="Cetak Mutasi" target="_blank">
                                            <i class="bi bi-printer me-1"></i> Cetak
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Belum ada data jamaah dengan riwayat pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($jamaahs->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan {{ $jamaahs->firstItem() }}–{{ $jamaahs->lastItem() }}
                    dari {{ $jamaahs->total() }} jamaah
                </small>
                {{ $jamaahs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
