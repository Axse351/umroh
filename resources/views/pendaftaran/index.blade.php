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
                    <div class="d-flex flex-wrap" style="gap:6px;">
                        {{-- Filter --}}
                        <form class="form-inline" method="GET">
                            <select name="jenis" class="form-control form-control-sm mr-1">
                                <option value="">Semua Jenis</option>
                                <option value="umroh" {{ request('jenis') == 'umroh' ? 'selected' : '' }}>Umroh
                                </option>
                                <option value="haji" {{ request('jenis') == 'haji' ? 'selected' : '' }}>Haji
                                </option>
                                <option value="haji_plus" {{ request('jenis') == 'haji_plus' ? 'selected' : '' }}>Haji
                                    Plus</option>
                                <option value="haji_furoda" {{ request('jenis') == 'haji_furoda' ? 'selected' : '' }}>Haji
                                    Furoda</option>
                            </select>
                            <select name="status" class="form-control form-control-sm mr-1">
                                <option value="">Semua Status</option>
                                @foreach (['draft', 'konfirmasi', 'dp_terbayar', 'lunas', 'berangkat', 'selesai', 'batal', 'refund'] as $s)
                                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $s)) }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-filter"></i></button>
                        </form>
                        {{-- Tambah --}}
                        <a href="{{ route('admin.pendaftaran.create', ['jenis' => 'umroh']) }}"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i> Umroh
                        </a>
                        <a href="{{ route('admin.pendaftaran.create', ['jenis' => 'haji']) }}"
                            class="btn btn-success btn-sm">
                            <i class="fas fa-plus mr-1"></i> Haji
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>No. Daftar</th>
                                    <th>Jamaah</th>
                                    <th>Paket / Keberangkatan</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th>Terbayar</th>
                                    <th>Sisa</th>
                                    <th>Status</th>
                                    <th style="min-width:180px;">Aksi</th>
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
                                        $jenisColor = $p->jenis === 'umroh' ? 'primary' : 'success';
                                    @endphp
                                    <tr>
                                        <td>{{ $pendaftarans->firstItem() + $i }}</td>

                                        <td>
                                            <span class="badge badge-light">{{ $p->no_pendaftaran }}</span>
                                        </td>

                                        <td>
                                            <strong>{{ $p->jamaah->nama_lengkap }}</strong><br>
                                            <small class="text-muted">{{ $p->jamaah->no_telepon }}</small>
                                        </td>

                                        <td>
                                            {{ $p->keberangkatan->paket->nama_paket ?? '-' }}<br>
                                            <small class="text-muted">
                                                {{ $p->keberangkatan->tanggal_berangkat?->format('d/m/Y') ?? '-' }}
                                            </small>
                                        </td>

                                        <td>
                                            <span class="badge badge-{{ $jenisColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $p->jenis)) }}
                                            </span>
                                        </td>

                                        <td>Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>

                                        <td class="text-success font-weight-bold">
                                            Rp {{ number_format($p->total_bayar ?? 0, 0, ',', '.') }}
                                        </td>

                                        <td
                                            class="{{ ($p->sisa_tagihan ?? 0) > 0 ? 'text-danger' : 'text-success' }} font-weight-bold">
                                            {{ ($p->sisa_tagihan ?? 0) > 0 ? 'Rp ' . number_format($p->sisa_tagihan, 0, ',', '.') : 'Lunas' }}
                                        </td>

                                        <td>
                                            <span class="badge badge-{{ $colors[$p->status] ?? 'secondary' }}">
                                                {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            {{-- Detail --}}
                                            <a href="{{ route('admin.pendaftaran.show', $p) }}"
                                                class="btn btn-info btn-sm mb-1" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('admin.pendaftaran.edit', $p) }}"
                                                class="btn btn-warning btn-sm mb-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Cetak Mutasi --}}
                                            <a href="{{ route('admin.pendaftaran.cetak-mutasi', $p) }}" target="_blank"
                                                class="btn btn-primary btn-sm mb-1" title="Cetak Mutasi Pembayaran">
                                                <i class="fas fa-print mr-1"></i> Mutasi
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('admin.pendaftaran.destroy', $p) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus pendaftaran ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm mb-1" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                            Tidak ada data pendaftaran
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($pendaftarans->hasPages())
                        <div class="d-flex justify-content-between align-items-center px-3 py-2">
                            <small class="text-muted">
                                Menampilkan {{ $pendaftarans->firstItem() }}–{{ $pendaftarans->lastItem() }}
                                dari {{ $pendaftarans->total() }} data
                            </small>
                            {{ $pendaftarans->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
