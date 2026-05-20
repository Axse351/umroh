@extends('layouts.app')

@section('title', 'Tambah Setoran')
@section('page-title', 'Tabungan')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.tabungan.index') }}">Data Tabungan</a></div>
    @if ($tabunganId)
        <div class="breadcrumb-item">
            <a href="{{ route('admin.tabungan.show', $tabunganId) }}">Detail Tabungan</a>
        </div>
    @endif
    <div class="breadcrumb-item active">Tambah Setoran</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-plus-circle mr-2"></i>Form Tambah Setoran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.setoran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Rekening Tabungan --}}
                        <div class="form-group">
                            <label>Rekening Tabungan <span class="text-danger">*</span></label>
                            <select name="tabungan_id" id="tabungan_id"
                                class="form-control @error('tabungan_id') is-invalid @enderror"
                                onchange="loadTabunganInfo(this)">
                                <option value="">-- Pilih Rekening --</option>
                                @foreach ($tabungans as $t)
                                    <option value="{{ $t->id }}" data-saldo="{{ $t->saldo }}"
                                        data-target="{{ $t->target_tabungan }}"
                                        data-jamaah="{{ $t->jamaah->nama_lengkap ?? '-' }}"
                                        data-jenis="{{ ucfirst($t->jenis) }}"
                                        {{ old('tabungan_id', $tabunganId) == $t->id ? 'selected' : '' }}>
                                        {{ $t->no_rekening_tabungan }} — {{ $t->jamaah->nama_lengkap ?? '-' }}
                                        ({{ ucfirst($t->jenis) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tabungan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Info saldo (ditampilkan setelah rekening dipilih) --}}
                        <div id="info-saldo" class="d-none mb-3">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="card shadow-sm border-0" style="background: #f0f4ff;">
                                        <div class="card-body py-2">
                                            <small class="text-muted d-block">Jamaah</small>
                                            <strong id="info-jamaah" class="text-dark">—</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card shadow-sm border-0" style="background: #e8f8f0;">
                                        <div class="card-body py-2">
                                            <small class="text-muted d-block">Saldo Saat Ini</small>
                                            <strong id="info-saldo-val" style="color: #1a9e5c;">—</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card shadow-sm border-0" style="background: #fff4e5;">
                                        <div class="card-body py-2">
                                            <small class="text-muted d-block">Target</small>
                                            <strong id="info-target" style="color: #d97706;">—</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Jenis --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Transaksi <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                        <option value="setor" {{ old('jenis', 'setor') == 'setor' ? 'selected' : '' }}>
                                            Setoran</option>
                                        <option value="tarik" {{ old('jenis') == 'tarik' ? 'selected' : '' }}>Penarikan
                                        </option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Status --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="diterima"
                                            {{ old('status', 'diterima') == 'diterima' ? 'selected' : '' }}>
                                            Langsung Diterima
                                        </option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                            Pending (perlu konfirmasi)
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Jumlah --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah Setoran (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_setor"
                                        class="form-control @error('jumlah_setor') is-invalid @enderror"
                                        value="{{ old('jumlah_setor') }}" min="1" placeholder="0">
                                    @error('jumlah_setor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Metode --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Metode Pembayaran <span class="text-danger">*</span></label>
                                    <select name="metode" class="form-control @error('metode') is-invalid @enderror">
                                        @foreach (['tunai' => 'Tunai', 'transfer' => 'Transfer Bank', 'debit' => 'Kartu Debit', 'kredit' => 'Kartu Kredit', 'qris' => 'QRIS'] as $val => $label)
                                            <option value="{{ $val }}"
                                                {{ old('metode', 'tunai') == $val ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('metode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Tanggal Setor --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Setor <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_setor"
                                        class="form-control @error('tanggal_setor') is-invalid @enderror"
                                        value="{{ old('tanggal_setor', date('Y-m-d')) }}">
                                    @error('tanggal_setor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Kolektor --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kolektor / Penerima
                                        <small class="text-muted">(opsional)</small>
                                    </label>
                                    <select name="karyawan_id"
                                        class="form-control @error('karyawan_id') is-invalid @enderror">
                                        <option value="">— Tidak Ada / Admin Langsung —</option>
                                        {{-- ✅ BENAR --}}
                                        @foreach ($kolektors as $k)
                                            <option value="{{ $k->id }}"
                                                {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_lengkap }} ({{ ucfirst($k->jabatan) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('karyawan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Pilih kolektor yang menerima uang secara langsung dari jamaah.
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Bukti Setor --}}
                        <div class="form-group">
                            <label>Bukti Setor <small class="text-muted">(opsional, foto/gambar)</small></label>
                            <input type="file" name="bukti_setor" class="form-control-file" accept="image/*"
                                onchange="previewBukti(this)">
                            <div id="preview-bukti" class="mt-2 d-none">
                                <img id="preview-img" src="" alt="Preview"
                                    style="max-height:150px; border-radius:6px;">
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2" placeholder="Keterangan tambahan...">{{ old('catatan') }}</textarea>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Setoran
                            </button>
                            @if ($tabunganId)
                                <a href="{{ route('admin.tabungan.show', $tabunganId) }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                            @else
                                <a href="{{ route('admin.tabungan.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Tampilkan info saldo ketika rekening dipilih
        function loadTabunganInfo(sel) {
            const opt = sel.options[sel.selectedIndex];
            const box = document.getElementById('info-saldo');

            if (!sel.value) {
                box.classList.add('d-none');
                return;
            }

            const fmt = n => 'Rp ' + parseInt(n).toLocaleString('id-ID');

            document.getElementById('info-jamaah').textContent = opt.dataset.jamaah;
            document.getElementById('info-saldo-val').textContent = fmt(opt.dataset.saldo);
            document.getElementById('info-target').textContent = fmt(opt.dataset.target);

            box.classList.remove('d-none');
        }

        // Preview gambar bukti setor
        function previewBukti(input) {
            const preview = document.getElementById('preview-bukti');
            const img = document.getElementById('preview-img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    img.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('d-none');
            }
        }

        // Auto-trigger info jika ada pre-selected tabungan_id
        document.addEventListener('DOMContentLoaded', function() {
            const sel = document.getElementById('tabungan_id');
            if (sel && sel.value) loadTabunganInfo(sel);
        });
    </script>
@endpush
