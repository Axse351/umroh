@extends('layouts.app')
@section('title', 'Data Supplier')
@section('page-title', 'Data Supplier')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Supplier</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Supplier</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="kategori" class="form-control form-control-sm mr-2">
                                <option value="">Semua Kategori</option>
                                @foreach (['perlengkapan', 'makanan', 'souvenir', 'percetakan', 'lainnya'] as $k)
                                    <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>
                                        {{ ucfirst($k) }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></button>
                        </form>
                        <a href="{{ route('supplier.create') }}" class="btn btn-primary btn-sm"><i
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
                                    <th>Nama Supplier</th>
                                    <th>Kategori</th>
                                    <th>PIC</th>
                                    <th>No. Telepon</th>
                                    <th>Bank</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suppliers as $i => $s)
                                    <tr>
                                        <td>{{ $suppliers->firstItem() + $i }}</td>
                                        <td><small class="text-muted">{{ $s->kode_supplier }}</small></td>
                                        <td><strong>{{ $s->nama_supplier }}</strong></td>
                                        <td><span class="badge badge-info">{{ ucfirst($s->kategori) }}</span></td>
                                        <td>{{ $s->nama_pic ?? '-' }}</td>
                                        <td>{{ $s->no_telepon }}</td>
                                        <td>{{ $s->nama_bank ?? '-' }}</td>
                                        <td><span
                                                class="badge badge-{{ $s->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($s->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('supplier.show', $s) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('supplier.edit', $s) }}" class="btn btn-warning btn-sm"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route('supplier.destroy', $s) }}" method="POST"
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
                    <div class="d-flex justify-content-end mt-3">{{ $suppliers->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
