@extends('layouts.app')

@section('title', 'Detail Pembelian')
@section('page-title', 'Detail Pembelian')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pembelian.index') }}">Data Pembelian</a></div>
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
                                    'diterima' => 'success',
                                    'sebagian' => 'warning',
                                    'batal' => 'danger',
                                ][$pembelian->status] ?? 'secondary';
                        @endphp
                        <div class="rounded-circle bg-{{ $statusColor }} d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:100px;height:100px;">
                            <i class="fas fa-shopping-cart text-white" style="font-size:2rem;"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $pembelian->no_pembelian }}</h5>
                        <p class="text-muted mb-2">{{ $pembelian->supplier->nama_supplier ?? '-' }}</p>
                        <span class="badge badge-{{ $statusColor }} badge-lg px-3 py-2">
                            <i class="fas fa-circle fa-xs mr-1"></i>{{ ucfirst($pembelian->status) }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.pembelian.edit', $pembelian) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.pembelian.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Info Supplier --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Info Supplier</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary rounded p-2 mr-3">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Nama Supplier</small>
                                <span>{{ $pembelian->supplier->nama_supplier ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info rounded p-2 mr-3">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">No. Telepon</small>
                                <span>{{ $pembelian->supplier->no_telepon ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded p-2 mr-3">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">PIC</small>
                                <span>{{ $pembelian->supplier->nama_pic ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-info-circle mr-2"></i>Informasi Pembelian</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">No. Pembelian</th>
                                    <td><code>{{ $pembelian->no_pembelian }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Supplier</th>
                                    <td>{{ $pembelian->supplier->nama_supplier ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Beli</th>
                                    <td>{{ \Carbon\Carbon::parse($pembelian->tanggal_beli)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Total</th>
                                    <td><strong class="text-primary">Rp
                                            {{ number_format($pembelian->total, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ $statusColor }}">{{ ucfirst($pembelian->status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dicatat Oleh</th>
                                    <td>{{ $pembelian->karyawan->nama_lengkap ?? '-' }}</td>
                                </tr>
                                @if ($pembelian->catatan)
                                    <tr>
                                        <th class="bg-light">Catatan</th>
                                        <td>{{ $pembelian->catatan }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Detail Produk --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-boxes mr-2"></i>Detail Produk</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Produk</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembelian->details as $i => $detail)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $detail->produk->nama_produk ?? '-' }}</td>
                                            <td>{{ $detail->qty }}</td>
                                            <td>{{ $detail->produk->satuan ?? '-' }}</td>
                                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                            <td><strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th colspan="5" class="text-right">Total</th>
                                        <th class="text-primary">Rp {{ number_format($pembelian->total, 0, ',', '.') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
