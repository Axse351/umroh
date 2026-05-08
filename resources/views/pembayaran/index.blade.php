@extends('layouts.app')

@section('title', 'Data Pembayaran')
@section('page-title', 'Data Pembayaran')

@section('breadcrumb')
    <div class="breadcrumb-item active">Data Pembayaran</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Pembayaran</h4>
                    <a href="{{ route('admin.pembayaran.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Pembayaran
                    </a>
                </div>
                <div class="card-body">

                    {{-- Filter Status --}}
                    <div class="mb-3">
                        <span class="text-muted small mr-2">Filter:</span>
                        <div class="d-flex flex-wrap" style="gap: 4px;">
                            @foreach (['', 'pending', 'verifikasi', 'diterima', 'ditolak'] as $s)
                                <a href="{{ route('admin.pembayaran.index', $s ? ['status' => $s] : []) }}"
                                    class="btn btn-sm {{ $status === $s || ($s === '' && !$status) ? 'btn-primary' : 'btn-outline-secondary' }}">
                                    {{ $s === '' ? 'Semua' : ucfirst($s) }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>No. Pembayaran</th>
                                    <th>Jamaah</th>
                                    <th>No. Pendaftaran</th>
                                    <th>Jenis</th>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pembayarans as $i => $item)
                                    @php
                                        $jenisBadge =
                                            [
                                                'dp' => 'warning',
                                                'cicilan' => 'info',
                                                'pelunasan' => 'success',
                                                'lainnya' => 'secondary',
                                            ][$item->jenis] ?? 'secondary';

                                        $statusBadge =
                                            [
                                                'pending' => 'secondary',
                                                'verifikasi' => 'warning',
                                                'diterima' => 'success',
                                                'ditolak' => 'danger',
                                            ][$item->status] ?? 'secondary';
                                    @endphp
                                    <tr>
                                        <td>{{ $pembayarans->firstItem() + $i }}</td>
                                        <td><span class="badge badge-light">{{ $item->no_pembayaran }}</span></td>
                                        <td>{{ $item->pendaftaran->jamaah->nama_lengkap ?? '-' }}</td>
                                        <td><span
                                                class="badge badge-light">{{ $item->pendaftaran->no_pendaftaran ?? '-' }}</span>
                                        </td>
                                        <td><span class="badge badge-{{ $jenisBadge }}">{{ ucfirst($item->jenis) }}</span>
                                        </td>
                                        <td>{{ ucfirst($item->metode_bayar) }}</td>
                                        <td>Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') }}</td>
                                        <td><span
                                                class="badge badge-{{ $statusBadge }}">{{ ucfirst($item->status) }}</span>
                                        </td>
                                        <td>
                                            {{-- Verifikasi / Tolak --}}
                                            @if ($item->status === 'pending' || $item->status === 'verifikasi')
                                                <form action="{{ route('admin.pembayaran.verifikasi', $item) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Terima pembayaran ini?')">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm" title="Terima">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.pembayaran.tolak', $item) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Tolak pembayaran ini?')">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm" title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.pembayaran.show', $item) }}"
                                                class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pembayaran.edit', $item) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.pembayaran.destroy', $item) }}" method="POST"
                                                class="d-inline"
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
                                        <td colspan="10" class="text-center text-muted">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($pembayarans->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                Menampilkan {{ $pembayarans->firstItem() }}–{{ $pembayarans->lastItem() }}
                                dari {{ $pembayarans->total() }} data
                            </small>
                            {{ $pembayarans->appends(request()->query())->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
