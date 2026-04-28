@extends('layouts.app')

@section('title', 'Laporan Stok')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Laporan Stok</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></div>
                <div class="breadcrumb-item active">Stok</div>
            </div>
        </div>

        <div class="section-body">

            {{-- Rekap --}}
            <div class="row">
                @php
                    $rekapItems = [
                        [
                            'label' => 'Total Produk',
                            'value' => $rekap['total_produk'] ?? 0,
                            'color' => 'bg-primary',
                            'icon' => 'fas fa-box',
                        ],
                        [
                            'label' => 'Total Stok',
                            'value' => number_format($rekap['total_stok'] ?? 0),
                            'color' => 'bg-success',
                            'icon' => 'fas fa-boxes',
                        ],
                        [
                            'label' => 'Stok Menipis',
                            'value' => $rekap['stok_menipis'] ?? 0,
                            'color' => 'bg-warning',
                            'icon' => 'fas fa-exclamation-triangle',
                        ],
                        [
                            'label' => 'Stok Habis',
                            'value' => $rekap['stok_habis'] ?? 0,
                            'color' => 'bg-danger',
                            'icon' => 'fas fa-times-circle',
                        ],
                    ];
                @endphp
                @foreach ($rekapItems as $r)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon {{ $r['color'] }}">
                                <i class="{{ $r['icon'] }}"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ $r['label'] }}</h4>
                                </div>
                                <div class="card-body">{{ $r['value'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tabel --}}
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-list mr-1"></i> Detail Stok Produk</h4>
                    <div class="card-header-action">
                        <span class="badge badge-primary">{{ $produks->count() }} produk</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Nama Produk</th>
                                    <th>Supplier</th>
                                    <th>Satuan</th>
                                    <th class="text-center">Stok</th>
                                    <th>Harga Jual</th>
                                    <th class="text-center">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produks as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><code>{{ $item->kode_produk ?? '-' }}</code></td>
                                        <td class="font-weight-bold">{{ $item->nama_produk }}</td>
                                        <td>{{ $item->supplier->nama ?? '-' }}</td>
                                        <td>{{ $item->satuan ?? '-' }}</td>
                                        <td
                                            class="text-center font-weight-bold
                                            {{ ($item->stok ?? 0) == 0
                                                ? 'text-danger'
                                                : (($item->stok ?? 0) <= ($item->stok_minimal ?? 5)
                                                    ? 'text-warning'
                                                    : 'text-success') }}">
                                            {{ $item->stok ?? 0 }}
                                        </td>
                                        <td>Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            @if (($item->stok ?? 0) == 0)
                                                <div class="badge badge-danger">Habis</div>
                                            @elseif (($item->stok ?? 0) <= ($item->stok_minimal ?? 5))
                                                <div class="badge badge-warning">Menipis</div>
                                            @else
                                                <div class="badge badge-success">Aman</div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i> Tidak ada data produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
