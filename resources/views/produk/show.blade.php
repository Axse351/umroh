@extends('layouts.app')

@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Data Produk</a></div>
    <div class="breadcrumb-item active">Detail</div>
@endsection

@section('content')
    <div class="section-body">
        <div class="row">

            {{-- Kolom Kiri --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        @if ($produk->foto)
                            <img src="{{ asset('storage/' . $produk->foto) }}" class="rounded img-fluid mb-3"
                                style="width:120px;height:120px;object-fit:cover;border:3px solid #6777ef;">
                        @else
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:120px;height:120px;">
                                <i class="fas fa-box text-white" style="font-size:2.5rem;"></i>
                            </div>
                        @endif
                        <h5 class="font-weight-bold mb-1">{{ $produk->nama_produk }}</h5>
                        <p class="text-muted mb-1"><code>{{ $produk->kode_produk }}</code></p>
                        <span class="badge badge-info">{{ ucwords(str_replace('_', ' ', $produk->kategori)) }}</span>
                        <br><br>
                        <span
                            class="badge badge-{{ $produk->status === 'aktif' ? 'success' : 'danger' }} badge-lg px-3 py-2">
                            <i class="fas fa-circle fa-xs mr-1"></i>{{ ucfirst($produk->status) }}
                        </span>
                        @if ($produk->stok <= $produk->stok_minimum)
                            <br><br>
                            <span class="badge badge-danger">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Stok Menipis
                            </span>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.produk.edit', $produk) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Stok Info --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Info Stok</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success rounded p-2 mr-3">
                                <i class="fas fa-cubes text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Stok Saat Ini</small>
                                <strong
                                    class="{{ $produk->stok <= $produk->stok_minimum ? 'text-danger' : 'text-success' }}">
                                    {{ $produk->stok }} {{ $produk->satuan }}
                                </strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning rounded p-2 mr-3">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Stok Minimum</small>
                                <span>{{ $produk->stok_minimum }} {{ $produk->satuan }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded p-2 mr-3">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Supplier</small>
                                <span>{{ $produk->supplier->nama_supplier ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-box mr-2"></i>Informasi Produk</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">Kode Produk</th>
                                    <td><code>{{ $produk->kode_produk }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama Produk</th>
                                    <td>{{ $produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kategori</th>
                                    <td>{{ ucwords(str_replace('_', ' ', $produk->kategori)) }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Satuan</th>
                                    <td>{{ $produk->satuan }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Harga Beli</th>
                                    <td>Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Harga Jual</th>
                                    <td><strong class="text-primary">Rp
                                            {{ number_format($produk->harga_jual, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Margin</th>
                                    <td>
                                        @php $margin = $produk->harga_jual - $produk->harga_beli; @endphp
                                        <span class="{{ $margin >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                                            Rp {{ number_format($margin, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Stok</th>
                                    <td>
                                        <strong class="{{ $produk->stok <= $produk->stok_minimum ? 'text-danger' : '' }}">
                                            {{ $produk->stok }} {{ $produk->satuan }}
                                        </strong>
                                        @if ($produk->stok <= $produk->stok_minimum)
                                            <span class="badge badge-danger ml-1">Menipis</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Supplier</th>
                                    <td>{{ $produk->supplier->nama_supplier ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span class="badge badge-{{ $produk->status === 'aktif' ? 'success' : 'danger' }}">
                                            {{ ucfirst($produk->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if ($produk->deskripsi)
                                    <tr>
                                        <th class="bg-light">Deskripsi</th>
                                        <td>{{ $produk->deskripsi }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Riwayat Stok Opname --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-clipboard-list mr-2"></i>Riwayat Stok Opname</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>No. Opname</th>
                                        <th>Stok Sistem</th>
                                        <th>Stok Fisik</th>
                                        <th>Selisih</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produk->stokOpnames ?? [] as $i => $o)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><code>{{ $o->no_opname }}</code></td>
                                            <td>{{ $o->stok_sistem }}</td>
                                            <td>{{ $o->stok_fisik }}</td>
                                            <td>
                                                <span
                                                    class="{{ $o->selisih > 0 ? 'text-success' : ($o->selisih < 0 ? 'text-danger' : '') }} font-weight-bold">
                                                    {{ $o->selisih > 0 ? '+' : '' }}{{ $o->selisih }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($o->tanggal_opname)->format('d/m/Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">Belum ada riwayat opname
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
