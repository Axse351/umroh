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
                    <a href="{{ route('admin.keberangkatan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Tambah Keberangkatan
                    </a>
                </div>
                <div class="card-body">

                    {{-- Filter Status --}}
                    <div class="mb-3">
                        <span class="text-muted small mr-2">Filter:</span>
                        @foreach (['', 'open', 'closed', 'berangkat', 'selesai', 'batal'] as $s)
                            <a href="{{ route('admin.keberangkatan.index', $s ? ['status' => $s] : []) }}"
                                class="btn btn-sm mr-1 {{ $status === $s || ($s === '' && !$status) ? 'btn-primary' : 'btn-outline-secondary' }}">
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($keberangkatans as $i => $item)
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
                                    <tr>
                                        <td>{{ $keberangkatans->firstItem() + $i }}</td>
                                        <td><span class="badge badge-light">{{ $item->kode_keberangkatan }}</span></td>
                                        <td>{{ $item->paket->nama_paket ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_berangkat)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pulang)->format('d/m/Y') }}</td>
                                        <td>{{ strtoupper($item->bandara_keberangkatan) }}</td>
                                        <td>{{ $item->kuota }} orang</td>
                                        <td>{{ $item->pembimbing->nama ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $badge }}">{{ ucfirst($item->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.keberangkatan.show', $item) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.keberangkatan.edit', $item) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.keberangkatan.destroy', $item) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        @if ($keberangkatans->hasPages())
                            <small class="text-muted">
                                Menampilkan {{ $keberangkatans->firstItem() }}–{{ $keberangkatans->lastItem() }}
                                dari {{ $keberangkatans->total() }} data
                            </small>
                            {{ $keberangkatans->appends(request()->query())->links() }}
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
