@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item active">Laporan</div>
            </div>
        </div>

        <div class="section-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            {{-- Menu Laporan --}}
            <div class="row">
                @php
                    $menus = [
                        [
                            'route' => 'admin.laporan.keuangan',
                            'icon' => 'fas fa-cash-register',
                            'label' => 'Keuangan',
                            'color' => 'bg-success',
                        ],
                        [
                            'route' => 'admin.laporan.jamaah',
                            'icon' => 'fas fa-users',
                            'label' => 'Jamaah',
                            'color' => 'bg-primary',
                        ],
                        [
                            'route' => 'admin.laporan.pembayaran',
                            'icon' => 'fas fa-credit-card',
                            'label' => 'Pembayaran',
                            'color' => 'bg-warning',
                        ],
                        [
                            'route' => 'admin.laporan.tabungan',
                            'icon' => 'fas fa-piggy-bank',
                            'label' => 'Tabungan',
                            'color' => 'bg-info',
                        ],
                        [
                            'route' => 'admin.laporan.stok',
                            'icon' => 'fas fa-boxes',
                            'label' => 'Stok',
                            'color' => 'bg-secondary',
                        ],
                        [
                            'route' => 'admin.laporan.keberangkatan',
                            'icon' => 'fas fa-plane-departure',
                            'label' => 'Keberangkatan',
                            'color' => 'bg-danger',
                        ],
                    ];
                @endphp
                @foreach ($menus as $menu)
                    <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                        <a href="{{ route($menu['route']) }}" class="text-decoration-none">
                            <div class="card card-statistic-1">
                                <div class="card-icon {{ $menu['color'] }}">
                                    <i class="{{ $menu['icon'] }}"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Laporan</h4>
                                    </div>
                                    <div class="card-body" style="font-size:14px;">
                                        {{ $menu['label'] }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Riwayat --}}
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-history mr-1"></i> Riwayat Laporan</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Jenis</th>
                                    <th>Periode</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporans as $item)
                                    <tr>
                                        <td>{{ $laporans->firstItem() + $loop->index }}</td>
                                        <td>{{ $item->judul ?? '-' }}</td>
                                        <td>
                                            <div class="badge badge-primary">{{ ucfirst($item->jenis ?? '-') }}</div>
                                        </td>
                                        <td>
                                            {{ $item->dari ? \Carbon\Carbon::parse($item->dari)->isoFormat('D MMM Y') : '-' }}
                                            @if ($item->sampai)
                                                &ndash; {{ \Carbon\Carbon::parse($item->sampai)->isoFormat('D MMM Y') }}
                                            @endif
                                        </td>
                                        <td>{{ $item->karyawan->nama ?? '-' }}</td>
                                        <td>{{ $item->created_at->isoFormat('D MMM Y') }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('laporan.destroy', $item) }}" method="POST"
                                                onsubmit="return confirm('Hapus laporan ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i> Belum ada riwayat laporan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($laporans->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Menampilkan {{ $laporans->firstItem() }}–{{ $laporans->lastItem() }} dari
                                {{ $laporans->total() }} data
                            </small>
                            {{ $laporans->links() }}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>
@endsection
