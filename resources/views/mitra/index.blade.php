@extends('layouts.app')
@section('title', 'Data Mitra')
@section('page-title', 'Data Mitra')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Mitra</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Mitra</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="jenis" class="form-control form-control-sm mr-2">
                                <option value="">Semua Jenis</option>
                                @foreach (['bank', 'asuransi', 'supplier', 'partner', 'lainnya'] as $j)
                                    <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>
                                        {{ ucfirst($j) }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></button>
                        </form>
                        <a href="{{ route('admin.mitra.create') }}" class="btn btn-primary btn-sm"><i
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
                                    <th>Nama Mitra</th>
                                    <th>Jenis</th>
                                    <th>PIC</th>
                                    <th>No. Telepon</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mitras as $i => $m)
                                    <tr>
                                        <td>{{ $mitras->firstItem() + $i }}</td>
                                        <td><small class="text-muted">{{ $m->kode_mitra }}</small></td>
                                        <td><strong>{{ $m->nama_mitra }}</strong></td>
                                        <td><span class="badge badge-info">{{ ucfirst($m->jenis) }}</span></td>
                                        <td>{{ $m->nama_pic ?? '-' }}</td>
                                        <td>{{ $m->no_telepon ?? '-' }}</td>
                                        <td><span
                                                class="badge badge-{{ $m->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($m->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.mitra.show', $m) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.mitra.edit', $m) }}" class="btn btn-warning btn-sm"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.mitra.destroy', $m) }}" method="POST"
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
                    <div class="d-flex justify-content-end mt-3">{{ $mitras->appends(request()->query())->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
