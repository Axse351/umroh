@extends('layouts.app')

@section('title', 'Data Pembayaran')

@section('content')
    <div class="container-fluid px-4 py-4">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-0">Data Pembayaran</h4>
                <small class="text-muted">Kelola seluruh transaksi pembayaran jamaah</small>
            </div>
            <a href="{{ route('admin.pembayaran.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Pembayaran
            </a>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filter Status --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body py-2">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <span class="text-muted small me-1">Filter:</span>
                    @foreach (['', 'pending', 'verifikasi', 'diterima', 'ditolak'] as $s)
                        <a href="{{ route('admin.pembayaran.index', $s ? ['status' => $s] : []) }}"
                            class="btn btn-sm {{ $status === $s || ($s === '' && !$status) ? 'btn-primary' : 'btn-outline-secondary' }}">
                            {{ $s === '' ? 'Semua' : ucfirst($s) }}
                        </a>
                    @endforeach
                </div>
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
                                <th>No. Pembayaran</th>
                                <th>Jamaah</th>
                                <th>No. Pendaftaran</th>
                                <th>Jenis</th>
                                <th>Metode</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pembayarans as $item)
                                <tr>
                                    <td class="px-3 text-muted small">{{ $pembayarans->firstItem() + $loop->index }}</td>
                                    <td>
                                        <span class="fw-semibold font-monospace small">{{ $item->no_pembayaran }}</span>
                                    </td>
                                    <td>{{ $item->pendaftaran->jamaah->nama_lengkap ?? '-' }}</td>
                                    <td>
                                        <span class="font-monospace small text-muted">
                                            {{ $item->pendaftaran->no_pendaftaran ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $jenisBadge =
                                                [
                                                    'dp' => 'warning',
                                                    'cicilan' => 'info',
                                                    'pelunasan' => 'success',
                                                    'lainnya' => 'secondary',
                                                ][$item->jenis] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $jenisBadge }}">{{ ucfirst($item->jenis) }}</span>
                                    </td>
                                    <td>{{ ucfirst($item->metode_bayar) }}</td>
                                    <td class="fw-semibold">
                                        Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_bayar)->isoFormat('D MMM Y') }}</td>
                                    <td>
                                        @php
                                            $statusBadge =
                                                [
                                                    'pending' => 'secondary',
                                                    'verifikasi' => 'warning',
                                                    'diterima' => 'success',
                                                    'ditolak' => 'danger',
                                                ][$item->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $statusBadge }}">{{ ucfirst($item->status) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">

                                            {{-- Verifikasi / Tolak --}}
                                            @if ($item->status === 'pending' || $item->status === 'verifikasi')
                                                <form action="{{ route('admin.pembayaran.verifikasi', $item) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-sm btn-success" title="Terima"
                                                        onclick="return confirm('Terima pembayaran ini?')">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.pembayaran.tolak', $item) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger" title="Tolak"
                                                        onclick="return confirm('Tolak pembayaran ini?')">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('admin.pembayaran.show', $item) }}"
                                                class="btn btn-sm btn-outline-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pembayaran.edit', $item) }}"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.pembayaran.destroy', $item) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        Belum ada data pembayaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($pembayarans->hasPages())
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $pembayarans->firstItem() }}–{{ $pembayarans->lastItem() }}
                        dari {{ $pembayarans->total() }} data
                    </small>
                    {{ $pembayarans->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
