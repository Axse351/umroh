@extends('layouts.app')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pembayaran.index') }}">Data Pembayaran</a></div>
    <div class="breadcrumb-item active">Detail</div>
@endsection

@section('content')
    <div class="section-body">
        <div class="row">

            {{-- Kolom Kiri --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3
                        bg-{{ ['pending' => 'secondary', 'verifikasi' => 'warning', 'diterima' => 'success', 'ditolak' => 'danger'][$pembayaran->status] ?? 'secondary' }}"
                            style="width:100px;height:100px;">
                            <i class="fas fa-money-bill-wave text-white" style="font-size:2rem;"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $pembayaran->no_pembayaran }}</h5>
                        <p class="text-muted mb-2">{{ $pembayaran->pendaftaran->jamaah->nama_lengkap ?? '-' }}</p>
                        <span
                            class="badge badge-{{ ['pending' => 'secondary', 'verifikasi' => 'warning', 'diterima' => 'success', 'ditolak' => 'danger'][$pembayaran->status] ?? 'secondary' }} badge-lg px-3 py-2">
                            <i class="fas fa-circle fa-xs mr-1"></i>{{ ucfirst($pembayaran->status) }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        @if ($pembayaran->status === 'pending' || $pembayaran->status === 'verifikasi')
                            <form action="{{ route('admin.pembayaran.verifikasi', $pembayaran) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Terima pembayaran ini?')">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-check mr-1"></i> Terima
                                </button>
                            </form>
                            <form action="{{ route('admin.pembayaran.tolak', $pembayaran) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Tolak pembayaran ini?')">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-times mr-1"></i> Tolak
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.pembayaran.edit', $pembayaran) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Bukti Bayar --}}
                @if ($pembayaran->bukti_bayar)
                    <div class="card">
                        <div class="card-header">
                            <h4>Bukti Pembayaran</h4>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" target="_blank">
                                <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" class="img-fluid rounded"
                                    style="max-height:250px;">
                            </a>
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-external-link-alt mr-1"></i> Lihat Penuh
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-receipt mr-2"></i>Informasi Pembayaran</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">No. Pembayaran</th>
                                    <td><code>{{ $pembayaran->no_pembayaran }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jamaah</th>
                                    <td>
                                        {{ $pembayaran->pendaftaran->jamaah->nama_lengkap ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Pendaftaran</th>
                                    <td>
                                        <code>{{ $pembayaran->pendaftaran->no_pendaftaran ?? '-' }}</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jenis Pembayaran</th>
                                    <td>
                                        @php
                                            $jenisBadge =
                                                [
                                                    'dp' => 'warning',
                                                    'cicilan' => 'info',
                                                    'pelunasan' => 'success',
                                                    'lainnya' => 'secondary',
                                                ][$pembayaran->jenis] ?? 'secondary';
                                        @endphp
                                        <span
                                            class="badge badge-{{ $jenisBadge }}">{{ ucfirst($pembayaran->jenis) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Metode Bayar</th>
                                    <td>{{ ucfirst($pembayaran->metode_bayar) }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jumlah Bayar</th>
                                    <td><strong class="text-success">Rp
                                            {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Bayar</th>
                                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d F Y') }}</td>
                                </tr>
                                @if ($pembayaran->bank_tujuan)
                                    <tr>
                                        <th class="bg-light">Bank Tujuan</th>
                                        <td>{{ $pembayaran->bank_tujuan }}</td>
                                    </tr>
                                @endif
                                @if ($pembayaran->no_rekening)
                                    <tr>
                                        <th class="bg-light">No. Rekening</th>
                                        <td>{{ $pembayaran->no_rekening }}</td>
                                    </tr>
                                @endif
                                @if ($pembayaran->nama_pengirim)
                                    <tr>
                                        <th class="bg-light">Nama Pengirim</th>
                                        <td>{{ $pembayaran->nama_pengirim }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th class="bg-light">Dicatat Oleh</th>
                                    <td>{{ $pembayaran->karyawan->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ ['pending' => 'secondary', 'verifikasi' => 'warning', 'diterima' => 'success', 'ditolak' => 'danger'][$pembayaran->status] ?? 'secondary' }}">
                                            {{ ucfirst($pembayaran->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if ($pembayaran->catatan)
                                    <tr>
                                        <th class="bg-light">Catatan</th>
                                        <td>{{ $pembayaran->catatan }}</td>
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
