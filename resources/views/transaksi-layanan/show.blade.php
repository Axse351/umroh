@extends('layouts.app')

@section('title', 'Detail Transaksi Layanan')
@section('page-title', 'Detail Transaksi Layanan')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.transaksi-layanan.index') }}">Transaksi Layanan</a></div>
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
                            $statusColor =
                                [
                                    'pending' => 'secondary',
                                    'proses' => 'warning',
                                    'selesai' => 'success',
                                    'batal' => 'danger',
                                ][$transaksiLayanan->status] ?? 'secondary';
                        @endphp
                        <div class="rounded-circle bg-{{ $statusColor }} d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:100px;height:100px;">
                            <i class="fas fa-concierge-bell text-white" style="font-size:2rem;"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $transaksiLayanan->no_transaksi }}</h5>
                        <p class="text-muted mb-2">{{ $transaksiLayanan->pendaftaran->jamaah->nama_lengkap ?? '-' }}</p>
                        <span class="badge badge-{{ $statusColor }} badge-lg px-3 py-2">
                            <i class="fas fa-circle fa-xs mr-1"></i>{{ ucfirst($transaksiLayanan->status) }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.transaksi-layanan.edit', $transaksiLayanan) }}"
                            class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.transaksi-layanan.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-receipt mr-2"></i>Informasi Transaksi</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">No. Transaksi</th>
                                    <td><code>{{ $transaksiLayanan->no_transaksi }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jamaah</th>
                                    <td>{{ $transaksiLayanan->pendaftaran->jamaah->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Pendaftaran</th>
                                    <td><code>{{ $transaksiLayanan->pendaftaran->no_pendaftaran ?? '-' }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Layanan</th>
                                    <td>{{ $transaksiLayanan->layanan->nama_layanan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Qty</th>
                                    <td>{{ $transaksiLayanan->qty }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Harga Satuan</th>
                                    <td>Rp {{ number_format($transaksiLayanan->harga_satuan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Total Harga</th>
                                    <td><strong class="text-primary">Rp
                                            {{ number_format($transaksiLayanan->total_harga, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Transaksi</th>
                                    <td>{{ \Carbon\Carbon::parse($transaksiLayanan->tanggal_transaksi)->format('d F Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ $statusColor }}">{{ ucfirst($transaksiLayanan->status) }}</span>
                                    </td>
                                </tr>
                                @if ($transaksiLayanan->catatan)
                                    <tr>
                                        <th class="bg-light">Catatan</th>
                                        <td>{{ $transaksiLayanan->catatan }}</td>
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
