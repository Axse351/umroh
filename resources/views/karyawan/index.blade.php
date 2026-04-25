@extends('layouts.app')

@section('title', 'Data Karyawan')
@section('page-title', 'Data Karyawan')

@section('breadcrumb')
    <div class="breadcrumb-item active">Data Karyawan</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Karyawan</h4>
                    <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Tambah Karyawan
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>No. Telepon</th>
                                    <th>Tgl Masuk</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($karyawans as $i => $k)
                                    <tr>
                                        <td>{{ $karyawans->firstItem() + $i }}</td>
                                        <td><span class="badge badge-light">{{ $k->kode_karyawan }}</span></td>
                                        <td>
                                            @if ($k->foto)
                                                <img src="{{ asset('storage/' . $k->foto) }}" class="rounded-circle mr-2"
                                                    width="30" height="30" style="object-fit:cover">
                                            @endif
                                            {{ $k->nama_lengkap }}
                                        </td>
                                        <td>{{ $k->jabatan }}</td>
                                        <td>{{ $k->no_telepon ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($k->tanggal_masuk)->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $k->status == 'aktif' ? 'success' : 'danger' }}">
                                                {{ ucfirst($k->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.karyawan.show', $k) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.karyawan.edit', $k) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.karyawan.destroy', $k) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
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
                    <div class="d-flex justify-content-end mt-3">
                        {{ $karyawans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
