@extends('layouts.app')

@section('title', 'Data Keberangkatan')
@section('page-title', 'Data Keberangkatan')

@section('breadcrumb')
    <div class="breadcrumb-item active">Data Keberangkatan</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Daftar Keberangkatan</h4>
                <a href="{{ route('admin.keberangkatan.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Keberangkatan
                </a>
            </div>

            <div class="card-body">

                {{-- Alert --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                {{-- Filter Status --}}
                <div class="mb-3 d-flex flex-wrap gap-1">
                    <span class="text-muted small mr-2 align-self-center">Filter:</span>
                    @foreach (['', 'open', 'closed', 'berangkat', 'selesai', 'batal'] as $s)
                        <a href="{{ route('admin.keberangkatan.index', $s ? ['status' => $s] : []) }}"
                            class="btn btn-sm {{ $status === $s || ($s === '' && !$status) ? 'btn-primary' : 'btn-outline-secondary' }}">
                            {{ $s === '' ? 'Semua' : ucfirst($s) }}
                        </a>
                    @endforeach
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Paket</th>
                                <th>Berangkat</th>
                                <th>Pulang</th>
                                <th>Bandara</th>
                                <th>Kuota</th>
                                <th>Pembimbing</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($keberangkatans as $i => $item)
                                @php
                                    $badge = [
                                        'open'      => 'success',
                                        'closed'    => 'secondary',
                                        'berangkat' => 'primary',
                                        'selesai'   => 'info',
                                        'batal'     => 'danger',
                                    ][$item->status] ?? 'secondary';
                                @endphp
                                <tr>
                                    <td>{{ $keberangkatans->firstItem() + $i }}</td>
                                    <td><span class="badge badge-light font-monospace">{{ $item->kode_keberangkatan }}</span></td>
                                    <td>{{ $item->paket->nama_paket ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_berangkat)->isoFormat('D MMM Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pulang)->isoFormat('D MMM Y') }}</td>
                                    <td><strong>{{ strtoupper($item->bandara_keberangkatan) }}</strong></td>
                                    <td>{{ $item->kuota }} orang</td>
                                    <td>{{ $item->pembimbing->nama ?? '<span class="text-muted">-</span>' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $badge }}">{{ ucfirst($item->status) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.keberangkatan.show', $item) }}"
                                            class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.keberangkatan.edit', $item) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.keberangkatan.destroy', $item) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                        Belum ada data keberangkatan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($keberangkatans->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $keberangkatans->firstItem() }}–{{ $keberangkatans->lastItem() }}
                            dari {{ $keberangkatans->total() }} data
                        </small>
                        {{ $keberangkatans->appends(request()->query())->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
