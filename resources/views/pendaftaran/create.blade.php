@extends('layouts.app')
@section('title', 'Tambah Pendaftaran')
@section('page-title', 'Tambah Pendaftaran')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pendaftaran.index') }}">Data Pendaftaran</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Pendaftaran <span
                            class="badge badge-{{ $jenis == 'umroh' ? 'primary' : 'success' }}">{{ ucfirst($jenis) }}</span>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pendaftaran.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="jenis" value="{{ $jenis }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jamaah <span class="text-danger">*</span></label>
                                    <select name="jamaah_id" class="form-control @error('jamaah_id') is-invalid @enderror">
                                        <option value="">-- Pilih Jamaah --</option>
                                        @foreach ($jamaah as $j)
                                            <option value="{{ $j->id }}"
                                                {{ old('jamaah_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_lengkap }} -
                                                {{ $j->nik }}</option>
                                        @endforeach
                                    </select>
                                    @error('jamaah_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Keberangkatan <span class="text-danger">*</span></label>
                                    <select name="keberangkatan_id"
                                        class="form-control @error('keberangkatan_id') is-invalid @enderror"
                                        id="sel-keberangkatan">
                                        <option value="">-- Pilih Keberangkatan --</option>
                                        @foreach ($keberangkatans as $kb)
                                            <option value="{{ $kb->id }}" data-double="{{ $kb->harga_double }}"
                                                data-triple="{{ $kb->harga_triple }}" data-quad="{{ $kb->harga_quad }}"
                                                {{ old('keberangkatan_id') == $kb->id ? 'selected' : '' }}>
                                                {{ $kb->paket->nama_paket }} -
                                                {{ \Carbon\Carbon::parse($kb->tanggal_berangkat)->format('d/m/Y') }} (Sisa:
                                                {{ $kb->sisa_kuota }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('keberangkatan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipe Kamar <span class="text-danger">*</span></label>
                                    <select name="tipe_kamar" class="form-control" id="sel-kamar">
                                        <option value="double" {{ old('tipe_kamar') == 'double' ? 'selected' : '' }}>Double
                                        </option>
                                        <option value="triple" {{ old('tipe_kamar') == 'triple' ? 'selected' : '' }}>Triple
                                        </option>
                                        <option value="quad" {{ old('tipe_kamar', 'quad') == 'quad' ? 'selected' : '' }}>
                                            Quad
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Jual <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="harga_jual" id="inp-harga"
                                            class="form-control @error('harga_jual') is-invalid @enderror"
                                            value="{{ old('harga_jual') }}">
                                    </div>
                                    @error('harga_jual')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DP Minimal <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="dp_minimal" id="inp-dp"
                                            class="form-control @error('dp_minimal') is-invalid @enderror"
                                            value="{{ old('dp_minimal') }}">
                                    </div>
                                    @error('dp_minimal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Agent</label>
                                    <select name="agent_id" class="form-control">
                                        <option value="">-- Tanpa Agent --</option>
                                        @foreach ($agents as $a)
                                            <option value="{{ $a->id }}"
                                                {{ old('agent_id') == $a->id ? 'selected' : '' }}>{{ $a->nama_agent }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Marketing</label>
                                    <select name="karyawan_id" class="form-control">
                                        <option value="">-- Pilih Marketing --</option>
                                        @foreach ($karyawans as $k)
                                            <option value="{{ $k->id }}"
                                                {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Daftar <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_daftar" class="form-control"
                                        value="{{ old('tanggal_daftar', now()->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Batas Pelunasan</label>
                                    <input type="date" name="batas_pelunasan" class="form-control"
                                        value="{{ old('batas_pelunasan') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>
                                Simpan</button>
                            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const dpPersen = 30; // bisa dari setting
        function updateHarga() {
            const sel = document.getElementById('sel-keberangkatan');
            const kamar = document.getElementById('sel-kamar').value;
            const opt = sel.options[sel.selectedIndex];
            if (!opt || !opt.value) return;
            const harga = parseInt(opt.dataset[kamar]) || 0;
            document.getElementById('inp-harga').value = harga;
            document.getElementById('inp-dp').value = Math.round(harga * dpPersen / 100);
        }
        document.getElementById('sel-keberangkatan').addEventListener('change', updateHarga);
        document.getElementById('sel-kamar').addEventListener('change', updateHarga);
    </script>
@endpush
