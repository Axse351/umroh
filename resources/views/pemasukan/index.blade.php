@extends('layouts.app')
@section('title', 'Data Pemasukan')
@section('page-title', 'Data Pemasukan')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Pemasukan</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Pemasukan</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="kategori" class="form-control form-control-sm mr-1">
                                <option value="">Semua Kategori</option>
                                @foreach (['pembayaran_jamaah', 'setoran_tabungan', 'transaksi_layanan', 'komisi', 'lainnya'] as $k)
                                    <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $k)) }}</option>
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
                        <a href="{{ route('admin.pemasukan.create') }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-plus mr-1"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button
                                type="button" class="close" data-dismiss="alert">&times;</button></div>
                    @endif
                    <div class="alert alert-success">
                        <strong>Total Pemasukan: Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>No. Pemasukan</th>
                                    <th>Sumber</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Dicatat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pemasukans as $i => $p)
                                    <tr>
                                        <td>{{ $pemasukans->firstItem() + $i }}</td>
                                        <td><small class="text-muted">{{ $p->no_pemasukan }}</small></td>
                                        <td>{{ $p->sumber }}</td>
                                        <td><span
                                                class="badge badge-success">{{ ucwords(str_replace('_', ' ', $p->kategori)) }}</span>
                                        </td>
                                        <td><strong class="text-success">Rp
                                                {{ number_format($p->jumlah, 0, ',', '.') }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                                        <td>{{ $p->karyawan->nama ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.pemasukan.show', $p) }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.pemasukan.edit', $p) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.pemasukan.destroy', $p) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">{{ $pemasukans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
