@extends('layouts.app')
@section('title', 'Data Setoran')
@section('page-title', 'Data Setoran')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Setoran</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Setoran</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="jenis" class="form-control form-control-sm mr-2">
                                <option value="">Semua Jenis</option>
                                <option value="umroh" {{ request('jenis') == 'umroh' ? 'selected' : '' }}>Umroh</option>
                                <option value="haji" {{ request('jenis') == 'haji' ? 'selected' : '' }}>Haji</option>
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></button>
                        </form>
                        <a href="{{ route('admin.setoran.create') }}" class="btn btn-primary btn-sm"><i
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
                                    <th>No. Setoran</th>
                                    <th>Jamaah</th>
                                    <th>No. Rekening</th>
                                    <th>Jenis</th>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($setorans as $i => $s)
                                    <tr>
                                        <td>{{ $setorans->firstItem() + $i }}</td>
                                        <td><small class="text-muted">{{ $s->no_setoran }}</small></td>
                                        <td>{{ $s->tabungan->jamaah->nama_lengkap ?? '-' }}</td>
                                        <td><small>{{ $s->tabungan->no_rekening_tabungan ?? '-' }}</small></td>
                                        <td><span
                                                class="badge badge-{{ $s->jenis == 'setor' ? 'success' : 'danger' }}">{{ ucfirst($s->jenis) }}</span>
                                        </td>
                                        <td>{{ ucfirst($s->metode) }}</td>
                                        <td><strong class="{{ $s->jenis == 'setor' ? 'text-success' : 'text-danger' }}">
                                                {{ $s->jenis == 'tarik' ? '-' : '+' }} Rp
                                                {{ number_format($s->jumlah_setor, 0, ',', '.') }}
                                            </strong></td>
                                        <td>{{ \Carbon\Carbon::parse($s->tanggal_setor)->format('d/m/Y') }}</td>
                                        <td><span class="badge badge-success">{{ ucfirst($s->status) }}</span></td>
                                        <td>
                                            <a href="{{ route('admin.setoran.show', $s) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <form action="{{ route('admin.setoran.destroy', $s) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin hapus? Saldo akan di-rollback.')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">{{ $setorans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
