@extends('layouts.app')

@section('title', 'Detail Layanan')
@section('page-title', 'Detail Layanan')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.layanan.index') }}">Data Layanan</a></div>
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
                            $jenisColor =
                                ['umroh' => 'primary', 'haji' => 'success', 'keduanya' => 'info'][$layanan->jenis] ??
                                'secondary';
                            $kategoriIcon =
                                [
                                    'visa' => 'passport',
                                    'asuransi' => 'shield-alt',
                                    'vaksin' => 'syringe',
                                    'manasik' => 'book-open',
                                    'perlengkapan' => 'box',
                                    'transportasi' => 'bus',
                                    'lainnya' => 'tag',
                                ][$layanan->kategori] ?? 'concierge-bell';
                        @endphp
                        <div class="rounded-circle bg-{{ $jenisColor }} d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:100px;height:100px;">
                            <i class="fas fa-{{ $kategoriIcon }} text-white" style="font-size:2rem;"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $layanan->nama_layanan }}</h5>
                        <p class="text-muted mb-1"><code>{{ $layanan->kode_layanan }}</code></p>
                        <span class="badge badge-{{ $jenisColor }}">{{ ucfirst($layanan->jenis) }}</span>
                        <br><br>
                        <span
                            class="badge badge-{{ $layanan->status === 'aktif' ? 'success' : 'danger' }} badge-lg px-3 py-2">
                            <i class="fas fa-circle fa-xs mr-1"></i>{{ ucfirst($layanan->status) }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.layanan.edit', $layanan) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-concierge-bell mr-2"></i>Informasi Layanan</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">Kode Layanan</th>
                                    <td><code>{{ $layanan->kode_layanan }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama Layanan</th>
                                    <td>{{ $layanan->nama_layanan }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jenis</th>
                                    <td><span
                                            class="badge badge-{{ $jenisColor }}">{{ ucfirst($layanan->jenis) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kategori</th>
                                    <td>{{ ucwords(str_replace('_', ' ', $layanan->kategori)) }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Harga</th>
                                    <td><strong class="text-primary">Rp
                                            {{ number_format($layanan->harga, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ $layanan->status === 'aktif' ? 'success' : 'danger' }}">
                                            {{ ucfirst($layanan->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if ($layanan->deskripsi)
                                    <tr>
                                        <th class="bg-light">Deskripsi</th>
                                        <td>{{ $layanan->deskripsi }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Riwayat Transaksi --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-history mr-2"></i>Riwayat Transaksi</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>No. Transaksi</th>
                                        <th>Jamaah</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($layanan->transaksiLayanans ?? [] as $i => $t)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><code>{{ $t->no_transaksi }}</code></td>
                                            <td>{{ $t->pendaftaran->jamaah->nama_lengkap ?? '-' }}</td>
                                            <td>{{ $t->qty }}</td>
                                            <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $sc =
                                                        [
                                                            'pending' => 'secondary',
                                                            'proses' => 'warning',
                                                            'selesai' => 'success',
                                                            'batal' => 'danger',
                                                        ][$t->status] ?? 'secondary';
                                                @endphp
                                                <span
                                                    class="badge badge-{{ $sc }}">{{ ucfirst($t->status) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">Belum ada transaksi</td>
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
