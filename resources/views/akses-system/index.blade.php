@extends('layouts.app')
@section('title', 'Akses System')
@section('page-title', 'Akses System')
@section('breadcrumb')
    <div class="breadcrumb-item active">Akses System</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Manajemen Akses</h4>
                    <a href="{{ route('akses-system.create') }}" class="btn btn-primary btn-sm"><i
                            class="fas fa-plus mr-1"></i> Tambah User</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Karyawan</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($akses as $i => $a)
                                    @php
                                        $roleColors = [
                                            'superadmin' => 'danger',
                                            'admin' => 'warning',
                                            'kasir' => 'success',
                                            'marketing' => 'primary',
                                            'gudang' => 'info',
                                            'viewer' => 'secondary',
                                        ];
                                    @endphp
                                    <tr>
                                        <td>{{ $akses->firstItem() + $i }}</td>
                                        <td>{{ $a->karyawan->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $a->user->email ?? '-' }}</td>
                                        <td><span
                                                class="badge badge-{{ $roleColors[$a->role] ?? 'secondary' }}">{{ ucfirst($a->role) }}</span>
                                        </td>
                                        <td><span
                                                class="badge badge-{{ $a->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($a->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('akses-system.show', $a) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('akses-system.edit', $a) }}" class="btn btn-warning btn-sm"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route('akses-system.destroy', $a) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin hapus? User login juga akan terhapus!')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">{{ $akses->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
