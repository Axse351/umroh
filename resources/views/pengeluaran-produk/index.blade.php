@extends('layouts.app')
@section('title', 'Data Pengeluaran Produk')
@section('page-title', 'Data Pengeluaran Produk')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Pengeluaran Produk</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-box-open mr-1"></i> Data Pengeluaran Produk</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.pengeluaran-produk.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Catat Pengeluaran
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.pengeluaran-produk.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <select name="keperluan" class="form-control">
                                        <option value="">Semua Keperluan</option>
                                        <option value="distribusi_jamaah"
                                            {{ $keperluan == 'distribusi_jamaah' ? 'selected' : '' }}>Distribusi Jamaah
                                        </option>
                                        <option value="internal" {{ $keperluan == 'internal' ? 'selected' : '' }}>
                                            Internal</option>
                                        <option value="rusak" {{ $keperluan == 'rusak' ? 'selected' : '' }}>
                                            Rusak</option>
                                        <option value="lainnya" {{ $keperluan == 'lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search mr-1"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Pengeluaran</th>
                                    <th>Produk</th>
                                    <th>Jamaah / Pendaftaran</th>
                                    <th class="text-center">Qty</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Keperluan</th>
                                    <th>Dicatat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengeluaranProduks as $i => $item)
                                    <tr>
                                        <td>{{ $pengeluaranProduks->firstItem() + $i }}</td>
                                        <td><code>{{ $item->no_pengeluaran_produk }}</code></td>
                                        <td class="font-weight-bold">{{ $item->produk->nama_produk ?? '-' }}</td>
                                        <td>
                                            @if ($item->pendaftaran)
                                                <span
                                                    class="d-block">{{ $item->pendaftaran->jamaah->nama_lengkap ?? '-' }}</span>
                                                <small
                                                    class="text-muted">{{ $item->pendaftaran->no_pendaftaran ?? '' }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ $item->qty }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d M Y') }}</td>
                                        <td>
                                            @php
                                                $keperluanMap = [
                                                    'distribusi_jamaah' => [
                                                        'label' => 'Distribusi Jamaah',
                                                        'class' => 'badge-primary',
                                                    ],
                                                    'internal' => ['label' => 'Internal', 'class' => 'badge-info'],
                                                    'rusak' => ['label' => 'Rusak', 'class' => 'badge-danger'],
                                                    'lainnya' => ['label' => 'Lainnya', 'class' => 'badge-secondary'],
                                                ];
                                                $kp = $keperluanMap[$item->keperluan] ?? [
                                                    'label' => ucfirst($item->keperluan),
                                                    'class' => 'badge-secondary',
                                                ];
                                            @endphp
                                            <div class="badge {{ $kp['class'] }}">{{ $kp['label'] }}</div>
                                        </td>
                                        <td>{{ $item->karyawan->nama_karyawan ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.pengeluaran-produk.show', $item) }}"
                                                class="btn btn-sm btn-info btn-icon" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pengeluaran-produk.edit', $item) }}"
                                                class="btn btn-sm btn-warning btn-icon" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.pengeluaran-produk.destroy', $item) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus data pengeluaran ini? Stok produk akan dikembalikan.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-icon"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i> Tidak ada data pengeluaran
                                            produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($pengeluaranProduks->hasPages())
                    <div class="card-footer">
                        {{ $pengeluaranProduks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
