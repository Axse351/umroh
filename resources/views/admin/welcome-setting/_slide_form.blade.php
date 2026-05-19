{{-- resources/views/admin/welcome-setting/_slide_form.blade.php --}}
@php
    $isEdit = $isEdit ?? false;
    $pfx = $isEdit ? 'edit_' : '';
    $statsId = $isEdit ? 'editStatsContainer' : 'addStatsContainer';
    $initStats =
        $isEdit || !$slide
            ? []
            : (is_array($slide->stats)
                ? $slide->stats
                : json_decode($slide->stats ?? '[]', true) ?? []);
@endphp

<div class="row">
    {{-- Badge --}}
    <div class="col-md-8">
        <div class="form-group">
            <label class="font-weight-bold">Badge / Label Atas <span class="text-danger">*</span></label>
            <input type="text" name="badge" id="{{ $pfx }}badge" class="form-control"
                value="{{ $slide->badge ?? '' }}" placeholder="✦ Perjalanan Suci Menuju Tanah Haram ✦" required
                maxlength="200">
            <small class="text-muted">Teks kecil di atas judul slide.</small>
        </div>
    </div>

    {{-- BG Color --}}
    <div class="col-md-2">
        <div class="form-group">
            <label class="font-weight-bold">Warna BG</label>
            <input type="color" name="bg_color" id="{{ $pfx }}bg_color" class="form-control"
                value="{{ $slide->bg_color ?? '#0a2342' }}">
            <small class="text-muted">Warna fallback.</small>
        </div>
    </div>

    {{-- Overlay Color --}}
    <div class="col-md-2">
        <div class="form-group">
            <label class="font-weight-bold">Overlay Warna</label>
            <input type="color" name="overlay_color" id="{{ $pfx }}overlay_color" class="form-control"
                value="{{ $slide->overlay_color ?? '#061529' }}">
            <small class="text-muted">Warna overlay gelap.</small>
        </div>
    </div>

    {{-- Title --}}
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-bold">Judul Slide <span class="text-danger">*</span></label>
            <textarea name="title" id="{{ $pfx }}title" class="form-control" rows="2" required
                placeholder="Wujudkan Impian &lt;span class='gold-text'&gt;Ibadah Umroh&lt;/span&gt; &amp; Haji Anda">{{ $slide->title ?? '' }}</textarea>
            <small class="text-muted">Boleh menggunakan HTML sederhana: <code>&lt;span class='gold-text'&gt;Teks
                    Emas&lt;/span&gt;</code></small>
        </div>
    </div>

    {{-- Description --}}
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-bold">Deskripsi Slide <span class="text-danger">*</span></label>
            <textarea name="description" id="{{ $pfx }}description" class="form-control" rows="3" required
                placeholder="Kami hadir membimbing perjalanan ibadah Anda dengan pelayanan terbaik...">{{ $slide->description ?? '' }}</textarea>
            <small class="text-muted">Boleh menggunakan <code>&lt;strong&gt;teks tebal&lt;/strong&gt;</code>.</small>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="col-md-6">
        <div class="form-group">
            <label class="font-weight-bold">Teks Tombol Utama (Kuning)</label>
            <input type="text" name="btn_primary_text" id="{{ $pfx }}btn_primary" class="form-control"
                value="{{ $slide->btn_primary_text ?? '' }}" placeholder="Lihat Paket Umroh" maxlength="100">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="font-weight-bold">Teks Tombol Sekunder (Outline)</label>
            <input type="text" name="btn_secondary_text" id="{{ $pfx }}btn_secondary" class="form-control"
                value="{{ $slide->btn_secondary_text ?? '' }}" placeholder="Tentang Kami" maxlength="100">
        </div>
    </div>

    {{-- Image --}}
    <div class="col-md-6">
        <div class="form-group">
            <label class="font-weight-bold">Gambar Background Slide</label>
            @if ($slide && $slide->image)
                <div class="mb-2">
                    <img src="{{ Storage::url($slide->image) }}" alt="" class="img-thumbnail"
                        style="max-height:100px;max-width:100%;">
                    <small class="text-muted d-block">Gambar saat ini. Upload baru untuk mengganti.</small>
                </div>
            @endif
            <div class="custom-file">
                <input type="file" name="image" class="custom-file-input" id="{{ $pfx }}slideImage"
                    accept="image/*" onchange="previewImg(this,'{{ $pfx }}prevSlideImg')">
                <label class="custom-file-label" for="{{ $pfx }}slideImage">Pilih gambar...</label>
            </div>
            <small class="text-muted">Format: JPG/PNG/WebP. Maks 5MB. Resolusi rekomendasi: 1920×1080px.</small>
            <img id="{{ $pfx }}prevSlideImg" src="#" alt="preview" class="mt-2 d-none img-thumbnail"
                style="max-height:100px;">
        </div>
    </div>

    {{-- Status (edit only) --}}
    @if ($isEdit)
        <div class="col-md-6">
            <div class="form-group">
                <label class="font-weight-bold d-block">Status Slide</label>
                <div class="custom-control custom-switch mt-2">
                    <input type="checkbox" class="custom-control-input" id="edit_is_active" name="is_active"
                        value="1">
                    <label class="custom-control-label" for="edit_is_active">Aktifkan slide ini</label>
                </div>
            </div>
        </div>
    @endif

    {{-- Stats --}}
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-bold">Statistik di Slide</label>
            <small class="text-muted d-block mb-2">Angka-angka yang tampil di bawah deskripsi slide. Maks 3
                item.</small>
            <div id="{{ $statsId }}">
                @foreach ($initStats as $i => $st)
                    <div class="stat-row input-group mb-2">
                        <input type="text" name="stats[{{ $i }}][num]"
                            class="form-control form-control-sm" value="{{ $st['num'] ?? '' }}"
                            placeholder="Angka (mis: 15+)">
                        <input type="text" name="stats[{{ $i }}][label]"
                            class="form-control form-control-sm" value="{{ $st['label'] ?? '' }}"
                            placeholder="Label (mis: Tahun Pengalaman)">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="this.closest('.stat-row').remove(); renumberStats('{{ $statsId }}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                onclick="addStatRow('{{ $statsId }}')">
                <i class="fas fa-plus mr-1"></i> Tambah Statistik
            </button>
        </div>
    </div>

</div>
