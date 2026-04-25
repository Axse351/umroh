@extends('layouts.app')
@section('title', 'Data Paket')
@section('page-title', 'Data Paket')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Paket</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Paket</h4>
                    <div>
                        <a href="{{ route('admin.paket.index', ['jenis' => 'umroh']) }}"
                            class="btn btn-sm {{ $jenis == 'umroh' ? 'btn-primary' : 'btn-outline-primary' }}">Umroh</a>
                        <a href="{{ route('admin.paket.index', ['jenis' => 'haji']) }}"
                            class="btn btn-sm {{ $jenis == 'haji' ? 'btn-success' : 'btn-outline-success' }}">Haji</a>
                        <a href="{{ route('admin.paket.index') }}" class="btn btn-sm btn-outline-secondary">Semua</a>
                        <a href="{{ route('admin.paket.create') }}" class="btn btn-primary btn-sm ml-2"><i
                                class="fas fa-plus mr-1"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Paket</th>
                                    <th>Jenis</th>
                                    <th>Durasi</th>
                                    <th>Maskapai</th>
                                    <th>Harga Quad</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pakets as $i => $p)
                                    <tr>
                                        <td>{{ $pakets->firstItem() + $i }}</td>
                                        <td><span class="badge badge-light">{{ $p->kode_paket }}</span></td>
                                        <td><strong>{{ $p->nama_paket }}</strong><br><small
                                                class="text-muted">{{ ucfirst($p->kategori) }}</small></td>
                                        <td><span
                                                class="badge badge-{{ $p->jenis == 'umroh' ? 'primary' : 'success' }}">{{ ucfirst($p->jenis) }}</span>
                                        </td>
                                        <td>{{ $p->durasi_hari }} hari</td>
                                        <td>{{ $p->maskapai->nama_maskapai ?? '-' }}</td>
                                        <td>Rp {{ number_format($p->harga_quad, 0, ',', '.') }}</td>
                                        <td><span
                                                class="badge badge-{{ $p->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($p->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.paket.show', $p) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.paket.edit', $p) }}" class="btn btn-warning btn-sm"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.paket.destroy', $p) }}" method="POST"
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
                    <div class="d-flex justify-content-end mt-3">{{ $pakets->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
