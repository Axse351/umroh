@extends('layouts.app')

@section('title', 'Detail Mutasi – ' . $jamaah->nama_lengkap)

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Detail Mutasi Pembayaran</h4>
            <small class="text-muted">{{ $jamaah->nama_lengkap }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.mutasi.cetak', $jamaah) }}" target="_blank"
                class="btn btn-dark">
                <i class="bi bi-printer me-1"></i> Cetak PDF
            </a>
            <a href="{{ route('admin.mutasi.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Info Jamaah --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <small class="text-muted d-block">Nama Lengkap</small>
                    <strong>{{ $jamaah->nama_lengkap }}</strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">No. Identitas</small>
                    <span class="font-monospace">{{ $jamaah->no_identitas ?? '-' }}</span>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">No. HP</small>
                    {{ $jamaah->no_hp ?? '-' }}
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Alamat</small>
                    {{ $jamaah->alamat ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Card --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 bg-primary bg-opacity-10 h-100">
                <div class="card-body text-center">
                    <div class="text-primary fs-4 fw-bold">
                        Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                    </div>
                    <small class="text-muted">Total Tagihan</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-success bg-opacity-10 h-100">
                <div class="card-body text-center">
                    <div class="text-success fs-4 fw-bold">
                        Rp {{ number_format($totalTerbayar, 0, ',', '.') }}
                    </div>
                    <small class="text-muted">Total Terbayar</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-{{ $sisaTagihan <= 0 ? 'success' : 'warning' }} bg-opacity-10 h-100">
                <div class="card-body text-center">
                    <div class="text-{{ $sisaTagihan <= 0 ? 'success' : 'warning' }} fs-4 fw-bold">
                        Rp {{ number_format(max($sisaTagihan, 0), 0, ',', '.') }}
                    </div>
                    <small class="text-muted">Sisa Tagihan</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Per Pendaftaran --}}
    @foreach ($jamaah->pendaftarans as $pendaftaran)
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <span class="fw-bold font-monospace">{{ $pendaftaran->no_pendaftaran }}</span>
                    <span class="ms-2 badge bg-{{ $pendaftaran->status === 'lunas' ? 'success' : 'warning' }}">
                        {{ ucfirst($pendaftaran->status) }}
                    </span>
                </div>
                <div class="text-muted small">
                    Paket: <strong>{{ $pendaftaran->paket->nama_paket ?? '-' }}</strong>
                    &nbsp;|&nbsp; Total: <strong>Rp {{ number_format($pendaftaran->total_harga, 0, ',', '.') }}</strong>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($pendaftaran->pembayarans->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-receipt d-block fs-4 mb-1"></i>
                        Belum ada transaksi pembayaran.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3">No. Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th class="text-center">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftaran->pembayarans as $bayar)
                                    <tr>
                                        <td class="px-3 font-monospace small">{{ $bayar->no_pembayaran }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->isoFormat('D MMM Y') }}</td>
                                        <td>
                                            @php
                                                $jenisBadge = ['dp'=>'warning','cicilan'=>'info','pelunasan'=>'success','lainnya'=>'secondary'][$bayar->jenis] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $jenisBadge }}">{{ ucfirst($bayar->jenis) }}</span>
                                        </td>
                                        <td>{{ ucfirst($bayar->metode_bayar) }}</td>
                                        <td class="fw-semibold {{ $bayar->status === 'diterima' ? 'text-success' : '' }}">
                                            Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            @php
                                                $statusBadge = ['pending'=>'secondary','verifikasi'=>'warning','diterima'=>'success','ditolak'=>'danger'][$bayar->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusBadge }}">{{ ucfirst($bayar->status) }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($bayar->bukti_bayar)
                                                <a href="{{ Storage::url($bayar->bukti_bayar) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-image"></i>
                                                </a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-semibold px-3">Subtotal Diterima</td>
                                    <td class="fw-bold text-success" colspan="3">
                                        Rp {{ number_format($pendaftaran->pembayarans->where('status','diterima')->sum('jumlah_bayar'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
            <div class="card-footer d-flex justify-content-end text-muted small gap-3">
                <span>Sisa: <strong class="text-danger">Rp {{ number_format($pendaftaran->sisa_tagihan, 0, ',', '.') }}</strong></span>
            </div>
        </div>
    @endforeach

</div>
@endsection
