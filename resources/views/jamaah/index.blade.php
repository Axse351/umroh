@extends('layouts.app')
@section('title', 'Data Jamaah')
@section('page-title', 'Data Jamaah')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Jamaah</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Jamaah</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <input type="text" name="search" class="form-control form-control-sm mr-2"
                                placeholder="Cari nama/NIK/passport..." value="{{ request('search') }}">
                            <select name="jenis" class="form-control form-control-sm mr-2">
                                <option value="">Semua</option>
                                <option value="umroh" {{ request('jenis') == 'umroh' ? 'selected' : '' }}>Umroh</option>
                                <option value="haji" {{ request('jenis') == 'haji' ? 'selected' : '' }}>Haji</option>
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></button>
                        </form>
                        <a href="{{ route('admin.jamaah.create') }}" class="btn btn-primary btn-sm ml-2"><i
                                class="fas fa-plus mr-1"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>No. Passport</th>
                                    <th>L/P</th>
                                    <th>No. Telepon</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jamaah as $i => $j)
                                    <tr>
                                        <td>{{ $jamaah->firstItem() + $i }}</td>
                                        <td>
                                            <img src="{{ $j->foto ? asset('storage/' . $j->foto) : asset('assets/img/avatar.png') }}"
                                                class="rounded-circle" width="35" height="35"
                                                style="object-fit:cover">
                                        </td>
                                        <td><strong>{{ $j->nama_lengkap }}</strong><br><small
                                                class="text-muted">{{ $j->kode_jamaah }}</small></td>
                                        <td>{{ $j->nik }}</td>
                                        <td>{{ $j->no_passport ?? '-' }}</td>
                                        <td><span
                                                class="badge badge-{{ $j->jenis_kelamin == 'laki-laki' ? 'info' : 'danger' }}">{{ $j->jenis_kelamin == 'laki-laki' ? 'L' : 'P' }}</span>
                                        </td>
                                        <td>{{ $j->no_telepon }}</td>
                                        <td><span
                                                class="badge badge-{{ $j->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($j->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.jamaah.show', $j) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.jamaah.edit', $j) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.jamaah.destroy', $j) }}" method="POST"
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
                    <div class="d-flex justify-content-end mt-3">{{ $jamaah->appends(request()->query())->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
