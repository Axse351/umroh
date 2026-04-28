@extends('layouts.app')
@section('title', 'Data Dokumen')
@section('page-title', 'Data Dokumen')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Dokumen</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Dokumen Jamaah</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="status" class="form-control form-control-sm mr-2">
                                <option value="">Semua Status</option>
                                @foreach (['pending', 'valid', 'expired', 'ditolak'] as $s)
                                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                            <select name="jenis_dokumen" class="form-control form-control-sm mr-2">
                                <option value="">Semua Jenis</option>
                                @foreach (['ktp', 'passport', 'foto', 'kartu_keluarga', 'akta_lahir', 'buku_nikah', 'surat_mahram', 'surat_kesehatan', 'visa', 'bukti_vaksin', 'lainnya'] as $j)
                                    <option value="{{ $j }}"
                                        {{ request('jenis_dokumen') == $j ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $j)) }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></button>
                        </form>
                        <a href="{{ route('admin.dokumen.create') }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-plus mr-1"></i> Upload</a>
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
                                    <th>Jamaah</th>
                                    <th>Jenis Dokumen</th>
                                    <th>File</th>
                                    <th>Tgl Upload</th>
                                    <th>Expired</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumens as $i => $d)
                                    <tr>
                                        <td>{{ $dokumens->firstItem() + $i }}</td>
                                        <td>{{ $d->jamaah->nama_lengkap ?? '-' }}</td>
                                        <td>{{ ucwords(str_replace('_', ' ', $d->jenis_dokumen)) }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $d->file_path) }}" target="_blank"
                                                class="btn btn-xs btn-outline-info">
                                                <i class="fas fa-file mr-1"></i> Lihat
                                            </a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($d->tanggal_upload)->format('d/m/Y') }}</td>
                                        <td>{{ $d->tanggal_expired ? \Carbon\Carbon::parse($d->tanggal_expired)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            @php $color = ['pending'=>'secondary','valid'=>'success','expired'=>'warning','ditolak'=>'danger'][$d->status] ?? 'secondary'; @endphp
                                            <span class="badge badge-{{ $color }}">{{ ucfirst($d->status) }}</span>
                                        </td>
                                        <td>
                                            @if ($d->status !== 'valid')
                                                <form action="{{ route('admin.dokumen.validasi', $d) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm" title="Validasi"><i
                                                            class="fas fa-check"></i></button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.dokumen.show', $d) }}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.dokumen.edit', $d) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.dokumen.destroy', $d) }}" method="POST"
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
                    <div class="d-flex justify-content-end mt-3">{{ $dokumens->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
