@extends('layouts.app')
@section('title', 'Data Maskapai')
@section('page-title', 'Data Maskapai')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Maskapai</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Maskapai</h4>
                    <a href="{{ route('admin.maskapai.create') }}" class="btn btn-primary btn-sm"><i
                            class="fas fa-plus mr-1"></i>
                        Tambah</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Maskapai</th>
                                    <th>Kode IATA</th>
                                    <th>No. Telepon</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($maskapais as $i => $m)
                                    <tr>
                                        <td>{{ $maskapais->firstItem() + $i }}</td>
                                        <td><span class="badge badge-light">{{ $m->kode_maskapai }}</span></td>
                                        <td>{{ $m->nama_maskapai }}</td>
                                        <td><span class="badge badge-info">{{ $m->kode_iata ?? '-' }}</span></td>
                                        <td>{{ $m->no_telepon ?? '-' }}</td>
                                        <td><span
                                                class="badge badge-{{ $m->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($m->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.maskapai.show', $m) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.maskapai.edit', $m) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.maskapai.destroy', $m) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">{{ $maskapais->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
