{{-- resources/views/admin/welcome-setting/_package_form.blade.php --}}
@php
    $isEdit = $isEdit ?? false;
    $pfx = $isEdit ? 'epkg_' : 'pkg_';
    $featId = $isEdit ? 'editFeaturesContainer' : 'addFeaturesContainer';
    $features = [];
    if ($package) {
        $features = is_array($package->features)
            ? $package->features
            : json_decode($package->features ?? '[]', true) ?? [];
    }
@endphp

<div class="row">
    {{-- Jenis --}}
    <div class="col-md-3">
        <div class="form-group">
            <label class="font-weight-bold">Jenis Paket <span class="text-danger">*</span></label>
            <select name="jenis" id="{{ $pfx }}jenis" class="form-control" required>
                <option value="umroh" {{ ($package->jenis ?? '') === 'umroh' ? 'selected' : '' }}>Umroh</option>
                <option value="haji" {{ ($package->jenis ?? '') === 'haji' ? 'selected' : '' }}>Haji</option>
            </select>
        </div>
    </div>

    {{-- Name --}}
    <div class="col-md-5">
        <div class="form-group">
            <label class="font-weight-bold">Nama Paket <span class="text-danger">*</span></label>
            <input type="text" name="name" id="{{ $pfx }}name" class="form-control"
                value="{{ $package->name ?? '' }}" placeholder="Paket Reguler" required maxlength="100">
        </div>
    </div>

    {{-- Badge --}}
    <div class="col-md-4">
        <div class="form-group">
            <label class="font-weight-bold">Badge / Label Khusus</label>
            <input type="text" name="badge" id="{{ $pfx }}badge" class="form-control"
                value="{{ $package->badge ?? '' }}" placeholder="Paling Diminati" maxlength="100">
            <small class="text-muted">Kosongkan jika tidak ada.</small>
        </div>
    </div>

    {{-- Price --}}
    <div class="col-md-4">
        <div class="form-group">
            <label class="font-weight-bold">Harga <span class="text-danger">*</span></label>
            <input type="text" name="price" id="{{ $pfx }}price" class="form-control"
                value="{{ $package->price ?? '' }}" placeholder="Rp 32.000.000" required maxlength="50">
        </div>
    </div>

    {{-- Duration --}}
    <div class="col-md-4">
        <div class="form-group">
            <label class="font-weight-bold">Durasi <span class="text-danger">*</span></label>
            <input type="text" name="duration" id="{{ $pfx }}duration" class="form-control"
                value="{{ $package->duration ?? '' }}" placeholder="12 Hari 11 Malam" required maxlength="50">
        </div>
    </div>

    {{-- Hotel --}}
    <div class="col-md-4">
        <div class="form-group">
            <label class="font-weight-bold">Hotel <span class="text-danger">*</span></label>
            <input type="text" name="hotel" id="{{ $pfx }}hotel" class="form-control"
                value="{{ $package->hotel ?? '' }}" placeholder="Hotel Bintang 4" required maxlength="100">
        </div>
    </div>

    {{-- Is Featured --}}
    <div class="col-md-6">
        <div class="form-group">
            <label class="font-weight-bold d-block">Tampilan Paket</label>
            <div class="custom-control custom-switch mt-2">
                <input type="checkbox" class="custom-control-input" id="{{ $pfx }}is_featured"
                    name="is_featured" value="1" {{ !empty($package->is_featured) ? 'checked' : '' }}>
                <label class="custom-control-label" for="{{ $pfx }}is_featured">
                    Tandai sebagai <strong>Featured</strong> (tampil menonjol)
                </label>
            </div>
        </div>
    </div>

    {{-- Is Active (edit only) --}}
    @if ($isEdit)
        <div class="col-md-6">
            <div class="form-group">
                <label class="font-weight-bold d-block">Status</label>
                <div class="custom-control custom-switch mt-2">
                    <input type="checkbox" class="custom-control-input" id="{{ $pfx }}is_active"
                        name="is_active" value="1" {{ !empty($package->is_active) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="{{ $pfx }}is_active">Paket aktif (tampil di
                        halaman)</label>
                </div>
            </div>
        </div>
    @endif

    {{-- Features --}}
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-bold">Fitur / Keuntungan Paket <span class="text-danger">*</span></label>
            <small class="text-muted d-block mb-2">Tambahkan minimal 1 fitur. Setiap baris = 1 fitur.</small>
            <div id="{{ $featId }}">
                @if ($isEdit && count($features) > 0)
                    @foreach ($features as $i => $f)
                        <div class="feature-row input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-check text-success"></i></span>
                            </div>
                            <input type="text" name="features[{{ $i }}]"
                                class="form-control form-control-sm" value="{{ $f }}"
                                placeholder="Fitur paket..." required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="this.closest('.feature-row').remove(); renumberFeatures('{{ $featId }}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Default 3 rows for add form --}}
                    @for ($i = 0; $i < 3; $i++)
                        <div class="feature-row input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-check text-success"></i></span>
                            </div>
                            <input type="text" name="features[{{ $i }}]"
                                class="form-control form-control-sm" placeholder="Fitur paket...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="this.closest('.feature-row').remove(); renumberFeatures('{{ $featId }}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
            <button type="button" class="btn btn-sm btn-outline-success mt-1"
                onclick="addFeatureRow('{{ $featId }}')">
                <i class="fas fa-plus mr-1"></i> Tambah Fitur
            </button>
        </div>
    </div>
</div>
