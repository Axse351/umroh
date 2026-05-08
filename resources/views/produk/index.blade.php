@extends('layouts.app')
@section('title', 'Data Produk')
@section('page-title', 'Data Produk')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Produk</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-box mr-1"></i> Data Produk</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Tambah Produk
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.produk.index') }}" class="mb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <select name="kategori" class="form-control">
                                        <option value="">Semua Kategori</option>
                                        @foreach ([
            'koper' => 'Koper',
            'tas' => 'Tas',
            'seragam' => 'Seragam',
            'buku_manasik' => 'Buku Manasik',
            'perlengkapan_sholat' => 'Perlengkapan Sholat',
            'souvenir' => 'Souvenir',
            'obat' => 'Obat',
            'lainnya' => 'Lainnya',
        ] as $value => $label)
                                            <option value="{{ $value }}" {{ $kategori == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search mr-1"></i> Filter
                                </button>
                                @if ($kategori)
                                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
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
                                    <th>Kode</th>
                                    <th>Foto</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Supplier</th>
                                    <th class="text-center">Stok</th>
                                    <th>Harga Jual</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produks as $i => $item)
                                    <tr>
                                        <td>{{ $produks->firstItem() + $i }}</td>
                                        <td><code>{{ $item->kode_produk }}</code></td>
                                        <td>
                                            @if ($item->foto)
                                                <img src="{{ asset('storage/' . $item->foto) }}"
                                                    alt="{{ $item->nama_produk }}" class="rounded"
                                                    style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                                    style="width: 45px; height: 45px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="font-weight-bold">{{ $item->nama_produk }}</td>
                                        <td>
                                            @php
                                                $kategoriLabel = [
                                                    'koper' => ['label' => 'Koper', 'color' => 'badge-primary'],
                                                    'tas' => ['label' => 'Tas', 'color' => 'badge-info'],
                                                    'seragam' => ['label' => 'Seragam', 'color' => 'badge-warning'],
                                                    'buku_manasik' => [
                                                        'label' => 'Buku Manasik',
                                                        'color' => 'badge-success',
                                                    ],
                                                    'perlengkapan_sholat' => [
                                                        'label' => 'Perlengkapan Sholat',
                                                        'color' => 'badge-secondary',
                                                    ],
                                                    'souvenir' => ['label' => 'Souvenir', 'color' => 'badge-danger'],
                                                    'obat' => ['label' => 'Obat', 'color' => 'badge-dark'],
                                                    'lainnya' => ['label' => 'Lainnya', 'color' => 'badge-light'],
                                                ][$item->kategori] ?? [
                                                    'label' => $item->kategori,
                                                    'color' => 'badge-secondary',
                                                ];
                                            @endphp
                                            <div class="badge {{ $kategoriLabel['color'] }}">
                                                {{ $kategoriLabel['label'] }}
                                            </div>
                                        </td>
                                        <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                                        <td class="text-center">
                                            @if ($item->stok <= $item->stok_minimum)
                                                <span class="badge badge-danger">
                                                    {{ number_format($item->stok) }} {{ $item->satuan }}
                                                </span>
                                            @else
                                                <span class="badge badge-success">
                                                    {{ number_format($item->stok) }} {{ $item->satuan }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                        <td>
                                            <div
                                                class="badge {{ $item->status == 'aktif' ? 'badge-success' : 'badge-secondary' }}">
                                                {{ ucfirst($item->status) }}
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.produk.show', $item) }}"
                                                class="btn btn-sm btn-info btn-icon" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.produk.edit', $item) }}"
                                                class="btn btn-sm btn-warning btn-icon" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.produk.destroy', $item) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin hapus produk {{ $item->nama_produk }}?')">
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
                                        <td colspan="10" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                            Tidak ada data produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($produks->hasPages())
                    <div class="card-footer">
                        {{ $produks->appends(request()->query())->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
