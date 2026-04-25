@extends('layouts.app')
@section('title', 'Data Pengeluaran')
@section('page-title', 'Data Pengeluaran')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Pengeluaran</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Pengeluaran</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="kategori" class="form-control form-control-sm mr-1">
                                <option value="">Semua Kategori</option>
                                @foreach (['operasional', 'gaji', 'visa', 'tiket', 'hotel', 'transportasi', 'perlengkapan', 'marketing', 'lainnya'] as $k)
                                    <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>
                                        {{ ucfirst($k) }}</option>
                                @endforeach
                            </select>
                            <select name="bulan" class="form-control form-control-sm mr-1">
                                <option value="">Semua Bulan</option>
                                @foreach (range(1, 12) as $b)
                                    <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="tahun" class="form-control form-control-sm mr-1"
                                value="{{ request('tahun', now()->year) }}" style="width:80px">
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></button>
                        </form>
                        <a href="{{ route('admin.pengeluaran.create') }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-plus mr-1"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button
                                type="button" class="close" data-dismiss="alert">&times;</button></div>
                    @endif
                    <div class="alert alert-danger">
                        <strong>Total Pengeluaran: Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>No. Pengeluaran</th>
                                    <th>Keperluan</th>
                                    <th>Kategori</th>
                                    <th>Penerima</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Bukti</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengeluarans as $i => $p)
                                    <tr>
                                        <td>{{ $pengeluarans->firstItem() + $i }}</td>
                                        <td><small class="text-muted">{{ $p->no_pengeluaran }}</small></td>
                                        <td>{{ $p->keperluan }}</td>
                                        <td><span class="badge badge-warning">{{ ucfirst($p->kategori) }}</span></td>
                                        <td>{{ $p->penerima ?? '-' }}</td>
                                        <td><strong class="text-danger">Rp
                                                {{ number_format($p->jumlah, 0, ',', '.') }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($p->bukti)
                                                <a href="{{ asset('storage/' . $p->bukti) }}" target="_blank"
                                                    class="btn btn-xs btn-outline-info"><i class="fas fa-image"></i></a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pengeluaran.show', $p) }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.pengeluaran.edit', $p) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.pengeluaran.destroy', $p) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">{{ $pengeluarans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
