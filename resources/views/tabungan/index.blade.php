@extends('layouts.app')
@section('title', 'Data Tabungan')
@section('page-title', 'Data Tabungan')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Tabungan</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Rekening Tabungan</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="jenis" class="form-control form-control-sm mr-2">
                                <option value="">Semua Jenis</option>
                                <option value="umroh" {{ request('jenis') == 'umroh' ? 'selected' : '' }}>Umroh</option>
                                <option value="haji" {{ request('jenis') == 'haji' ? 'selected' : '' }}>Haji</option>
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></button>
                        </form>
                        <a href="{{ route('admin.tabungan.create') }}" class="btn btn-primary btn-sm"><i
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
                                    <th>No. Rekening</th>
                                    <th>Jamaah</th>
                                    <th>Jenis</th>
                                    <th>Target</th>
                                    <th>Saldo</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tabungans as $i => $t)
                                    <tr>
                                        <td>{{ $tabungans->firstItem() + $i }}</td>
                                        <td><small class="text-muted">{{ $t->no_rekening_tabungan }}</small></td>
                                        <td><strong>{{ $t->jamaah->nama_lengkap ?? '-' }}</strong></td>
                                        <td><span
                                                class="badge badge-{{ $t->jenis == 'umroh' ? 'info' : 'warning' }}">{{ ucfirst($t->jenis) }}</span>
                                        </td>
                                        <td>Rp {{ number_format($t->target_tabungan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($t->saldo, 0, ',', '.') }}</td>
                                        <td style="min-width:120px">
                                            @php $pct = $t->target_tabungan > 0 ? min(100, round($t->saldo / $t->target_tabungan * 100)) : 0; @endphp
                                            <div class="progress" style="height:14px">
                                                <div class="progress-bar bg-{{ $pct >= 100 ? 'success' : 'info' }}"
                                                    style="width:{{ $pct }}%">{{ $pct }}%</div>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge badge-{{ $t->status == 'aktif' ? 'success' : ($t->status == 'selesai' ? 'primary' : 'danger') }}">{{ ucfirst($t->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.tabungan.show', $t) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.tabungan.edit', $t) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.tabungan.destroy', $t) }}" method="POST"
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
                    <div class="d-flex justify-content-end mt-3">{{ $tabungans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
