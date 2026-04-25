@extends('layouts.app')
@section('title', 'Data Pendaftaran')
@section('page-title', 'Data Pendaftaran')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Pendaftaran</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Pendaftaran</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="jenis" class="form-control form-control-sm mr-1">
                                <option value="">Semua Jenis</option>
                                <option value="umroh" {{ request('jenis') == 'umroh' ? 'selected' : '' }}>Umroh</option>
                                <option value="haji" {{ request('jenis') == 'haji' ? 'selected' : '' }}>Haji</option>
                                <option value="haji_plus" {{ request('jenis') == 'haji_plus' ? 'selected' : '' }}>Haji Plus
                                </option>
                                <option value="haji_furoda" {{ request('jenis') == 'haji_furoda' ? 'selected' : '' }}>Haji
                                    Furoda
                                </option>
                            </select>
                            <select name="status" class="form-control form-control-sm mr-1">
                                <option value="">Semua Status</option>
                                @foreach (['draft', 'konfirmasi', 'dp_terbayar', 'lunas', 'berangkat', 'selesai', 'batal', 'refund'] as $s)
                                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-filter"></i></button>
                        </form>
                        <a href="{{ route('admin.pendaftaran.create', ['jenis' => 'umroh']) }}"
                            class="btn btn-primary btn-sm mr-1"><i class="fas fa-plus mr-1"></i> Umroh</a>
                        <a href="{{ route('admin.pendaftaran.create', ['jenis' => 'haji']) }}"
                            class="btn btn-success btn-sm"><i class="fas fa-plus mr-1"></i> Haji</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>No. Daftar</th>
                                    <th>Jamaah</th>
                                    <th>Paket/Keberangkatan</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th>Terbayar</th>
                                    <th>Sisa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftarans as $i => $p)
                                    @php
                                        $colors = [
                                            'draft' => 'secondary',
                                            'konfirmasi' => 'info',
                                            'dp_terbayar' => 'primary',
                                            'lunas' => 'success',
                                            'berangkat' => 'dark',
                                            'selesai' => 'success',
                                            'batal' => 'danger',
                                            'refund' => 'warning',
                                        ];
                                    @endphp
                                    <tr>
                                        <td>{{ $pendaftarans->firstItem() + $i }}</td>
                                        <td><span class="badge badge-light">{{ $p->no_pendaftaran }}</span></td>
                                        <td>
                                            <strong>{{ $p->jamaah->nama_lengkap }}</strong><br>
                                            <small class="text-muted">{{ $p->jamaah->no_telepon }}</small>
                                        </td>
                                        <td>
                                            {{ $p->keberangkatan->paket->nama_paket ?? '-' }}<br>
                                            <small
                                                class="text-muted">{{ $p->keberangkatan->tanggal_berangkat?->format('d/m/Y') ?? '-' }}</small>
                                        </td>
                                        <td><span
                                                class="badge badge-{{ $p->jenis == 'umroh' ? 'primary' : 'success' }}">{{ ucfirst($p->jenis) }}</span>
                                        </td>
                                        <td>Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                                        <td class="text-success">Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                                        <td class="{{ $p->sisa_tagihan > 0 ? 'text-danger' : 'text-success' }}">Rp
                                            {{ number_format($p->sisa_tagihan, 0, ',', '.') }}</td>
                                        <td><span
                                                class="badge badge-{{ $colors[$p->status] ?? 'secondary' }}">{{ ucfirst(str_replace('_', ' ', $p->status)) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pendaftaran.show', $p) }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.pendaftaran.edit', $p) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.pendaftaran.destroy', $p) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus?')">
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
                    <div class="d-flex justify-content-end mt-3">{{ $pendaftarans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
