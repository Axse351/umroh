@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Laporan Keuangan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></div>
                <div class="breadcrumb-item active">Keuangan</div>
            </div>
        </div>

        <div class="section-body">

            {{-- Filter --}}
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-filter mr-1"></i> Filter Periode</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.laporan.keuangan') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dari</label>
                                    <input type="date" name="dari" value="{{ $dari }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sampai</label>
                                    <input type="date" name="sampai" value="{{ $sampai }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
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
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pemasukan</h4>
                            </div>
                            <div class="card-body">
                                Rp {{ number_format($rekap['total_pemasukan'] ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pengeluaran</h4>
                            </div>
                            <div class="card-body">
                                Rp {{ number_format($rekap['total_pengeluaran'] ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Saldo / Laba Bersih</h4>
                            </div>
                            <div class="card-body">
                                Rp
                                {{ number_format(($rekap['total_pemasukan'] ?? 0) - ($rekap['total_pengeluaran'] ?? 0), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Pemasukan per Kategori --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-arrow-circle-down mr-1 text-success"></i> Pemasukan per Kategori</h4>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pemasukans as $item)
                                        <tr>
                                            <td>{{ ucfirst($item->kategori) }}</td>
                                            <td class="text-right font-weight-bold text-success">
                                                Rp {{ number_format($item->total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted py-4">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if ($pemasukans->count())
                                    <tfoot>
                                        <tr class="bg-light">
                                            <th>Total</th>
                                            <th class="text-right text-success">
                                                Rp {{ number_format($pemasukans->sum('total'), 0, ',', '.') }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Pengeluaran per Kategori --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-arrow-circle-up mr-1 text-danger"></i> Pengeluaran per Kategori</h4>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengeluarans as $item)
                                        <tr>
                                            <td>{{ ucfirst($item->kategori) }}</td>
                                            <td class="text-right font-weight-bold text-danger">
                                                Rp {{ number_format($item->total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted py-4">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if ($pengeluarans->count())
                                    <tfoot>
                                        <tr class="bg-light">
                                            <th>Total</th>
                                            <th class="text-right text-danger">
                                                Rp {{ number_format($pengeluarans->sum('total'), 0, ',', '.') }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
