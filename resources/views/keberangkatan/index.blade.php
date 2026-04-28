@extends('layouts.app')

@section('title', 'Data Keberangkatan')

@section('content')
    <div class="container-fluid px-4 py-4">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-0">Data Keberangkatan</h4>
                <small class="text-muted">Kelola jadwal keberangkatan umroh/haji</small>
            </div>
            <a href="{{ route('admin.keberangkatan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Keberangkatan
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
                    @foreach (['', 'open', 'closed', 'berangkat', 'selesai', 'batal'] as $s)
                        <a href="{{ route('admin.keberangkatan.index', $s ? ['status' => $s] : []) }}"
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
                                <th>Kode</th>
                                <th>Paket</th>
                                <th>Tanggal Berangkat</th>
                                <th>Tanggal Pulang</th>
                                <th>Bandara</th>
                                <th>Kuota</th>
                                <th>Pembimbing</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($keberangkatans as $item)
                                <tr>
                                    <td class="px-3 text-muted small">{{ $keberangkatans->firstItem() + $loop->index }}</td>
                                    <td>
                                        <span
                                            class="fw-semibold font-monospace small">{{ $item->kode_keberangkatan }}</span>
                                    </td>
                                    <td>{{ $item->paket->nama_paket ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_berangkat)->isoFormat('D MMM Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pulang)->isoFormat('D MMM Y') }}</td>
                                    <td>{{ strtoupper($item->bandara_keberangkatan) }}</td>
                                    <td>{{ $item->kuota }} orang</td>
                                    <td>{{ $item->pembimbing->nama ?? '-' }}</td>
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
                                        <span class="badge bg-{{ $badge }}">{{ ucfirst($item->status) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('admin.keberangkatan.show', $item) }}"
                                                class="btn btn-sm btn-outline-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.keberangkatan.edit', $item) }}"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.keberangkatan.destroy', $item) }}" method="POST"
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
                                        Belum ada data keberangkatan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($keberangkatans->hasPages())
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $keberangkatans->firstItem() }}–{{ $keberangkatans->lastItem() }}
                        dari {{ $keberangkatans->total() }} data
                    </small>
                    {{ $keberangkatans->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
