@extends('layouts.app')

@section('title', 'Edit Pembayaran')

@section('content')
    <div class="container-fluid px-4 py-4">

        {{-- Header --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h4 class="fw-bold mb-0">Edit Pembayaran</h4>
                <small class="text-muted font-monospace">{{ $pembayaran->no_pembayaran }}</small>
            </div>
        </div>

        <form action="{{ route('pembayaran.update', $pembayaran) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row g-4">

                {{-- Kolom Kiri --}}
                <div class="col-lg-8">

                    {{-- Info Pendaftaran (read-only) --}}
                    <div class="card shadow-sm mb-4 border-0 bg-light">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Jamaah</small>
                                    <span
                                        class="fw-semibold">{{ $pembayaran->pendaftaran->jamaah->nama_lengkap ?? '-' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">No. Pendaftaran</small>
                                    <span
                                        class="fw-semibold font-monospace">{{ $pembayaran->pendaftaran->no_pendaftaran ?? '-' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Paket</small>
                                    <span>{{ $pembayaran->pendaftaran->keberangkatan->paket->nama_paket ?? '-' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Tanggal Berangkat</small>
                                    <span>{{ $pembayaran->pendaftaran->keberangkatan->tanggal_berangkat?->format('d/m/Y') ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Pembayaran --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-semibold bg-white border-bottom">
                            <i class="bi bi-cash-coin me-2 text-success"></i>Detail Pembayaran
                        </div>
                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Jumlah Bayar <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="jumlah_bayar"
                                            value="{{ old('jumlah_bayar', $pembayaran->jumlah_bayar) }}" min="1"
                                            step="1000" class="form-control @error('jumlah_bayar') is-invalid @enderror">
                                        @error('jumlah_bayar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_bayar"
                                        value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar?->format('Y-m-d')) }}"
                                        class="form-control @error('tanggal_bayar') is-invalid @enderror">
                                    @error('tanggal_bayar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Metode Bayar <span class="text-danger">*</span></label>
                                    <select name="metode_bayar"
                                        class="form-select @error('metode_bayar') is-invalid @enderror">
                                        @foreach (['tunai', 'transfer', 'debit', 'kredit', 'qris'] as $m)
                                            <option value="{{ $m }}"
                                                {{ old('metode_bayar', $pembayaran->metode_bayar) == $m ? 'selected' : '' }}>
                                                {{ ucfirst($m) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('metode_bayar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-select @error('jenis') is-invalid @enderror">
                                        @foreach (['dp', 'cicilan', 'pelunasan', 'lainnya'] as $j)
                                            <option value="{{ $j }}"
                                                {{ old('jenis', $pembayaran->jenis) == $j ? 'selected' : '' }}>
                                                {{ ucfirst($j) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Bank Tujuan</label>
                                    <input type="text" name="bank_tujuan"
                                        value="{{ old('bank_tujuan', $pembayaran->bank_tujuan) }}"
                                        placeholder="BCA, Mandiri, dll."
                                        class="form-control @error('bank_tujuan') is-invalid @enderror">
                                    @error('bank_tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No. Rekening</label>
                                    <input type="text" name="no_rekening"
                                        value="{{ old('no_rekening', $pembayaran->no_rekening) }}"
                                        class="form-control @error('no_rekening') is-invalid @enderror">
                                    @error('no_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nama Pengirim</label>
                                    <input type="text" name="nama_pengirim"
                                        value="{{ old('nama_pengirim', $pembayaran->nama_pengirim) }}"
                                        class="form-control @error('nama_pengirim') is-invalid @enderror">
                                    @error('nama_pengirim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Bukti Bayar --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-semibold bg-white border-bottom">
                            <i class="bi bi-image me-2 text-info"></i>Bukti Pembayaran
                        </div>
                        <div class="card-body">
                            @if ($pembayaran->bukti_bayar)
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Bukti saat ini:</small>
                                    <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" alt="Bukti Bayar"
                                        class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            @endif
                            <label class="form-label">Upload Bukti Baru <small class="text-muted">(opsional, maks
                                    2MB)</small></label>
                            <input type="file" name="bukti_bayar" accept="image/*"
                                class="form-control @error('bukti_bayar') is-invalid @enderror">
                            @error('bukti_bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-semibold bg-white border-bottom">
                            <i class="bi bi-journal-text me-2 text-secondary"></i>Catatan
                        </div>
                        <div class="card-body">
                            <textarea name="catatan" rows="3" placeholder="Catatan tambahan (opsional)..."
                                class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $pembayaran->catatan) }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- Kolom Kanan --}}
                <div class="col-lg-4">

                    {{-- Status --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-semibold bg-white border-bottom">
                            <i class="bi bi-toggle-on me-2 text-warning"></i>Status Pembayaran
                        </div>
                        <div class="card-body">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                @foreach (['pending', 'verifikasi', 'diterima', 'ditolak'] as $s)
                                    <option value="{{ $s }}"
                                        {{ old('status', $pembayaran->status) == $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-3">
                                <small class="text-muted">
                                    <ul class="ps-3 mb-0">
                                        <li><strong>Pending</strong> – Menunggu verifikasi</li>
                                        <li><strong>Verifikasi</strong> – Sedang diproses</li>
                                        <li><strong>Diterima</strong> – Pembayaran valid</li>
                                        <li><strong>Ditolak</strong> – Pembayaran tidak valid</li>
                                    </ul>
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Info Ringkasan --}}
                    <div class="card shadow-sm mb-4 border-0 bg-light">
                        <div class="card-body">
                            <small class="text-muted d-block mb-1">No. Pembayaran</small>
                            <span class="fw-bold font-monospace">{{ $pembayaran->no_pembayaran }}</span>
                            <hr class="my-2">
                            <small class="text-muted d-block mb-1">Dibuat oleh</small>
                            <span>{{ $pembayaran->karyawan->nama ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>

                </div>

            </div>
        </form>

    </div>
@endsection
