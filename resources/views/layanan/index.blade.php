@extends('layouts.app')
@section('title', 'Data Layanan')
@section('page-title', 'Data Layanan')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Layanan</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Layanan</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="jenis" class="form-control form-control-sm mr-2">
                                <option value="">Semua Jenis</option>
                                <option value="umroh" {{ request('jenis') == 'umroh' ? 'selected' : '' }}>Umroh</option>
                                <option value="haji" {{ request('jenis') == 'haji' ? 'selected' : '' }}>Haji</option>
                                <option value="keduanya" {{ request('jenis') == 'keduanya' ? 'selected' : '' }}>Keduanya
                                </option>
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></button>
                        </form>
                        <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-plus mr-1"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button
                                type="button" class="close" data-dismiss="alert">&times;</button></div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Layanan</th>
                                    <th>Jenis</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($layanans as $i => $l)
                                    <tr>
                                        <td>{{ $layanans->firstItem() + $i }}</td>
                                        <td><small class="text-muted">{{ $l->kode_layanan }}</small></td>
                                        <td><strong>{{ $l->nama_layanan }}</strong></td>
                                        <td><span
                                                class="badge badge-{{ $l->jenis == 'umroh' ? 'info' : ($l->jenis == 'haji' ? 'warning' : 'secondary') }}">{{ ucfirst($l->jenis) }}</span>
                                        </td>
                                        <td>{{ ucwords(str_replace('_', ' ', $l->kategori)) }}</td>
                                        <td>Rp {{ number_format($l->harga, 0, ',', '.') }}</td>
                                        <td><span
                                                class="badge badge-{{ $l->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($l->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.layanan.show', $l) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.layanan.edit', $l) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.layanan.destroy', $l) }}" method="POST"
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
                    <div class="d-flex justify-content-end mt-3">{{ $layanans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
