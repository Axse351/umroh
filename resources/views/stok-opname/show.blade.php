@extends('layouts.app')

@section('title', 'Detail Stok Opname')
@section('page-title', 'Detail Stok Opname')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.stok-opname.index') }}">Stok Opname</a></div>
    <div class="breadcrumb-item active">Detail</div>
@endsection

@section('content')
    <div class="section-body">
        <div class="row">

            {{-- Kolom Kiri --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        @php
                            $selisihColor =
                                $stokOpname->selisih > 0
                                    ? 'success'
                                    : ($stokOpname->selisih < 0
                                        ? 'danger'
                                        : 'secondary');
                            $selisihIcon =
                                $stokOpname->selisih > 0
                                    ? 'arrow-up'
                                    : ($stokOpname->selisih < 0
                                        ? 'arrow-down'
                                        : 'equals');
                        @endphp
                        <div class="rounded-circle bg-{{ $selisihColor }} d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:100px;height:100px;">
                            <i class="fas fa-{{ $selisihIcon }} text-white" style="font-size:2rem;"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $stokOpname->no_opname }}</h5>
                        <p class="text-muted mb-2">{{ $stokOpname->produk->nama_produk ?? '-' }}</p>
                        <span class="badge badge-{{ $selisihColor }} badge-lg px-3 py-2">
                            Selisih: {{ $stokOpname->selisih > 0 ? '+' : '' }}{{ $stokOpname->selisih }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.stok-opname.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-clipboard-check mr-2"></i>Informasi Stok Opname</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">No. Opname</th>
                                    <td><code>{{ $stokOpname->no_opname }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Produk</th>
                                    <td>{{ $stokOpname->produk->nama_produk ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kode Produk</th>
                                    <td><code>{{ $stokOpname->produk->kode_produk ?? '-' }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Stok Sistem</th>
                                    <td>{{ $stokOpname->stok_sistem }} {{ $stokOpname->produk->satuan ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Stok Fisik</th>
                                    <td>{{ $stokOpname->stok_fisik }} {{ $stokOpname->produk->satuan ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Selisih</th>
                                    <td>
                                        <strong class="text-{{ $selisihColor }}">
                                            {{ $stokOpname->selisih > 0 ? '+' : '' }}{{ $stokOpname->selisih }}
                                            {{ $stokOpname->produk->satuan ?? '' }}
                                        </strong>
                                        @if ($stokOpname->selisih > 0)
                                            <span class="badge badge-success ml-1">Lebih</span>
                                        @elseif ($stokOpname->selisih < 0)
                                            <span class="badge badge-danger ml-1">Kurang</span>
                                        @else
                                            <span class="badge badge-secondary ml-1">Sesuai</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Opname</th>
                                    <td>{{ \Carbon\Carbon::parse($stokOpname->tanggal_opname)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dilakukan Oleh</th>
                                    <td>{{ $stokOpname->karyawan->nama_lengkap ?? '-' }}</td>
                                </tr>
                                @if ($stokOpname->keterangan)
                                    <tr>
                                        <th class="bg-light">Keterangan</th>
                                        <td>{{ $stokOpname->keterangan }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
