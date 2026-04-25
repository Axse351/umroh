@extends('layouts.app')

@section('title', 'Data Agent')
@section('page-title', 'Data Agent')

@section('breadcrumb')
    <div class="breadcrumb-item active">Data Agent</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Agent</h4>
                    <div>
                        <a href="{{ route('admin.agent.index', ['jenis' => 'umroh']) }}"
                            class="btn btn-sm {{ $jenis == 'umroh' ? 'btn-primary' : 'btn-outline-primary' }}">Umroh</a>
                        <a href="{{ route('admin.agent.index', ['jenis' => 'haji']) }}"
                            class="btn btn-sm {{ $jenis == 'haji' ? 'btn-success' : 'btn-outline-success' }}">Haji</a>
                        <a href="{{ route('admin.agent.index') }}" class="btn btn-sm btn-outline-secondary">Semua</a>
                        <a href="{{ route('admin.agent.create') }}" class="btn btn-primary btn-sm ml-2"><i
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
                                    <th>Nama Agent</th>
                                    <th>PIC</th>
                                    <th>Jenis</th>
                                    <th>No. Telepon</th>
                                    <th>Komisi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agents as $i => $a)
                                    <tr>
                                        <td>{{ $agents->firstItem() + $i }}</td>
                                        <td><span class="badge badge-light">{{ $a->kode_agent }}</span></td>
                                        <td>{{ $a->nama_agent }}</td>
                                        <td>{{ $a->nama_pic }}</td>
                                        <td><span
                                                class="badge badge-{{ $a->jenis == 'umroh' ? 'primary' : ($a->jenis == 'haji' ? 'success' : 'info') }}">{{ ucfirst($a->jenis) }}</span>
                                        </td>
                                        <td>{{ $a->no_telepon }}</td>
                                        <td>{{ $a->komisi_persen }}%</td>
                                        <td><span
                                                class="badge badge-{{ $a->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($a->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.agent.show', $a) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.agent.edit', $a) }}" class="btn btn-warning btn-sm"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.agent.destroy', $a) }}" method="POST"
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
                    <div class="d-flex justify-content-end mt-3">{{ $agents->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
