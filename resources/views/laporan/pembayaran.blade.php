@extends('layouts.app')

@section('title', 'Laporan Pembayaran')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Laporan Pembayaran</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></div>
                <div class="breadcrumb-item active">Pembayaran</div>
            </div>
        </div>

        <div class="section-body">

            {{-- Filter --}}
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-filter mr-1"></i> Filter</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.laporan.pembayaran') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Dari</label>
                                    <input type="date" name="dari" value="{{ $dari }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sampai</label>
                                    <input type="date" name="sampai" value="{{ $sampai }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search mr-1"></i> Tampilkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Rekap --}}
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pembayaran</h4>
                            </div>
                            <div class="card-body">Rp {{ number_format($total, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Transaksi</h4>
                            </div>
                            <div class="card-body">{{ $pembayarans->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel --}}
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-list mr-1"></i> Detail Transaksi</h4>
                    <div class="card-header-action">
                        <span class="badge badge-primary">{{ $pembayarans->count() }} data</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Pembayaran</th>
                                    <th>Jamaah</th>
                                    <th>Jenis</th>
                                    <th>Metode</th>
                                    <th>Nama Pengirim</th>
                                    <th>Tanggal</th>
                                    <th class="text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pembayarans as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><code>{{ $item->no_pembayaran }}</code></td>
                                        <td>{{ $item->pendaftaran->jamaah->nama_lengkap ?? '-' }}</td>
                                        <td>
                                            @php
                                                $jenisBadge =
                                                    [
                                                        'dp' => 'warning',
                                                        'cicilan' => 'info',
                                                        'pelunasan' => 'success',
                                                        'lainnya' => 'secondary',
                                                    ][$item->jenis] ?? 'secondary';
                                            @endphp
                                            <div class="badge badge-{{ $jenisBadge }}">
                                                {{ ucfirst($item->jenis) }}
                                            </div>
                                        </td>
                                        <td>{{ ucfirst($item->metode_bayar) }}</td>
                                        <td>{{ $item->nama_pengirim ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_bayar)->isoFormat('D MMM Y') }}</td>
                                        <td class="text-right font-weight-bold text-success">
                                            Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i> Tidak ada data.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($pembayarans->count())
                                <tfoot>
                                    <tr class="bg-light">
                                        <th colspan="7">Total</th>
                                        <th class="text-right text-success">
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
