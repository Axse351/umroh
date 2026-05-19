@extends('layouts.app')

@section('title', 'CMS Welcome Page')
@section('page-title', 'CMS Welcome Page')

@push('style')
    <style>
        /* ===== FIX MODAL STISLA ===== */
        /* Stisla sets overflow:hidden on .main-content yang block modal scroll */
        body.modal-open {
            overflow: auto !important;
            padding-right: 0 !important;
        }

        .modal {
            overflow-y: auto !important;
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal.fade .modal-dialog {
            z-index: 1050 !important;
        }

        /* Pastikan modal xl bisa scroll */
        .modal-xl .modal-body {
            max-height: 75vh;
            overflow-y: auto;
        }

        /* Nav pills styling */
        .nav-pills .nav-link.active {
            background-color: #6777ef;
        }

        .nav-pills .nav-link {
            color: #6777ef;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </div>
    <div class="breadcrumb-item">CMS Welcome Page</div>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- ===== NAV PILLS ===== --}}
            <ul class="nav nav-pills mb-4" id="cmsTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#tab-general">
                        <i class="fas fa-sliders-h mr-1"></i> Umum
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#tab-slides">
                        <i class="fas fa-images mr-1"></i> Hero Slides
                        <span class="badge badge-light text-dark ml-1">{{ $slides->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#tab-packages">
                        <i class="fas fa-box-open mr-1"></i> Paket
                        <span class="badge badge-light text-dark ml-1">{{ $umroh->count() + $haji->count() }}</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="cmsTabContent">

                {{-- ==================================================
                     TAB 1: GENERAL
                ================================================== --}}
                <div class="tab-pane fade show active" id="tab-general">
                    <form action="{{ route('admin.welcome-setting.update-general') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf @method('PUT')

                        {{-- BRAND --}}
                        <div class="card">
                            <div class="card-header bg-gradient-primary text-white">
                                <h4 class="mb-0"><i class="fas fa-star mr-2"></i>Brand &amp; Identitas</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama Brand <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="brand_name" class="form-control"
                                                value="{{ $settings['brand_name'] ?? '' }}" placeholder="GENMIM" required>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tagline / Sub Brand <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="brand_tagline" class="form-control"
                                                value="{{ $settings['brand_tagline'] ?? '' }}"
                                                placeholder="Travel &amp; Tour" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Berdiri Sejak <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="brand_since" class="form-control"
                                                value="{{ $settings['brand_since'] ?? '' }}" placeholder="2009"
                                                maxlength="10" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Logo Brand</label>
                                            @if (!empty($settings['brand_logo']))
                                                <div class="mb-2 d-flex align-items-center">
                                                    <img src="{{ Storage::url($settings['brand_logo']) }}" alt="Logo"
                                                        class="img-thumbnail" style="max-height:70px;max-width:180px;">
                                                    <form action="{{ route('admin.welcome-setting.delete-image') }}"
                                                        method="POST" class="d-inline ml-2"
                                                        onsubmit="return confirm('Hapus logo ini?')">
                                                        @csrf @method('DELETE')
                                                        <input type="hidden" name="key" value="brand_logo">
                                                        <button class="btn btn-danger btn-sm" title="Hapus Logo">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                            <div class="custom-file">
                                                <input type="file" name="brand_logo" class="custom-file-input"
                                                    id="inputBrandLogo" accept="image/*"
                                                    onchange="previewImg(this,'prevBrandLogo')">
                                                <label class="custom-file-label" for="inputBrandLogo">Pilih
                                                    file...</label>
                                            </div>
                                            <small class="text-muted">Format: JPG/PNG/SVG. Maks 2MB.</small>
                                            <img id="prevBrandLogo" src="#" alt="preview"
                                                class="mt-2 d-none img-thumbnail" style="max-height:70px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ABOUT --}}
                        <div class="card">
                            <div class="card-header bg-gradient-info text-white">
                                <h4 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Tentang Kami</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Judul Halaman About <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="about_title" class="form-control"
                                                value="{{ $settings['about_title'] ?? '' }}"
                                                placeholder="Mitra Ibadah Terpercaya Sejak 2009" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Badge Angka <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="about_badge_num" class="form-control"
                                                value="{{ $settings['about_badge_num'] ?? '' }}" placeholder="15+"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Badge Label <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="about_badge_label" class="form-control"
                                                value="{{ $settings['about_badge_label'] ?? '' }}"
                                                placeholder="TAHUN AMANAH" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Paragraf 1 <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="about_text1" class="form-control" rows="4" required
                                                placeholder="Deskripsi pertama tentang perusahaan...">{{ $settings['about_text1'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Paragraf 2 <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="about_text2" class="form-control" rows="4" required
                                                placeholder="Deskripsi kedua tentang pencapaian...">{{ $settings['about_text2'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Foto About (Kiri)</label>
                                            @if (!empty($settings['about_image']))
                                                <div class="mb-2 d-flex align-items-center">
                                                    <img src="{{ Storage::url($settings['about_image']) }}"
                                                        alt="About" class="img-thumbnail"
                                                        style="max-height:100px;max-width:200px;">
                                                    <form action="{{ route('admin.welcome-setting.delete-image') }}"
                                                        method="POST" class="d-inline ml-2"
                                                        onsubmit="return confirm('Hapus gambar ini?')">
                                                        @csrf @method('DELETE')
                                                        <input type="hidden" name="key" value="about_image">
                                                        <button class="btn btn-danger btn-sm"><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            @endif
                                            <div class="custom-file">
                                                <input type="file" name="about_image" class="custom-file-input"
                                                    id="inputAboutImg" accept="image/*"
                                                    onchange="previewImg(this,'prevAboutImg')">
                                                <label class="custom-file-label" for="inputAboutImg">Pilih file...</label>
                                            </div>
                                            <small class="text-muted">Format: JPG/PNG. Maks 5MB.</small>
                                            <img id="prevAboutImg" src="#" alt="preview"
                                                class="mt-2 d-none img-thumbnail" style="max-height:100px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- STATS --}}
                        <div class="card">
                            <div class="card-header bg-gradient-success text-white">
                                <h4 class="mb-0"><i class="fas fa-chart-bar mr-2"></i>Statistik (4 item)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @for ($i = 1; $i <= 4; $i++)
                                        <div class="col-md-3">
                                            <div class="card border shadow-sm">
                                                <div class="card-body p-3">
                                                    <div class="text-center mb-2">
                                                        <span class="badge badge-primary">Statistik
                                                            {{ $i }}</span>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Angka / Nilai</label>
                                                        <input type="text" name="stat{{ $i }}_num"
                                                            class="form-control form-control-sm"
                                                            value="{{ $settings['stat' . $i . '_num'] ?? '' }}"
                                                            placeholder="15+" required>
                                                    </div>
                                                    <div class="form-group mb-0">
                                                        <label class="small font-weight-bold">Label</label>
                                                        <input type="text" name="stat{{ $i }}_label"
                                                            class="form-control form-control-sm"
                                                            value="{{ $settings['stat' . $i . '_label'] ?? '' }}"
                                                            placeholder="Tahun Pengalaman" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        {{-- CONTACT --}}
                        <div class="card">
                            <div class="card-header bg-gradient-warning text-white">
                                <h4 class="mb-0"><i class="fas fa-phone-alt mr-2"></i>Informasi Kontak</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Telepon <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="contact_phone" class="form-control"
                                                value="{{ $settings['contact_phone'] ?? '' }}"
                                                placeholder="+62 21 1234 5678" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">WhatsApp (Tampil) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="contact_wa" class="form-control"
                                                value="{{ $settings['contact_wa'] ?? '' }}"
                                                placeholder="+62 812 3456 7890" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">WhatsApp (Link / wa.me) <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">wa.me/</span>
                                                </div>
                                                <input type="text" name="contact_wa_link" class="form-control"
                                                    value="{{ $settings['contact_wa_link'] ?? '' }}"
                                                    placeholder="628123456789" required>
                                            </div>
                                            <small class="text-muted">Format: 628xxxxxxxxxx (tanpa tanda + atau
                                                spasi)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="contact_email" class="form-control"
                                                value="{{ $settings['contact_email'] ?? '' }}"
                                                placeholder="info@example.com" required>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Alamat Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="contact_address" class="form-control"
                                                value="{{ $settings['contact_address'] ?? '' }}"
                                                placeholder="Jl. Sudirman No. 123, Jakarta Pusat" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SEO --}}
                        <div class="card">
                            <div class="card-header bg-gradient-dark text-white">
                                <h4 class="mb-0"><i class="fas fa-search mr-2"></i>SEO &amp; Meta Tag</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="font-weight-bold">Meta Title (SEO) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="seo_title" class="form-control"
                                        value="{{ $settings['seo_title'] ?? '' }}"
                                        placeholder="GENMIM Travel &amp; Tour — Umroh &amp; Haji Terpercaya" required>
                                    <small class="text-muted">Rekomendasi: 50–60 karakter.</small>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold">Meta Description (SEO) <span
                                            class="text-danger">*</span></label>
                                    <textarea name="seo_description" class="form-control" rows="3" required
                                        placeholder="Deskripsi singkat untuk mesin pencari...">{{ $settings['seo_description'] ?? '' }}</textarea>
                                    <small class="text-muted">Rekomendasi: 150–160 karakter.</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mb-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save mr-2"></i>Simpan Semua Pengaturan Umum
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ==================================================
                     TAB 2: HERO SLIDES
                ================================================== --}}
                <div class="tab-pane fade" id="tab-slides">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-0">Manajemen Hero Slides</h5>
                            <small class="text-muted">Slide yang tampil di banner utama halaman depan.</small>
                        </div>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddSlide">
                            <i class="fas fa-plus mr-1"></i> Tambah Slide Baru
                        </button>
                    </div>

                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="60" class="text-center">No</th>
                                            <th width="90" class="text-center">Gambar</th>
                                            <th>Badge</th>
                                            <th>Judul Slide</th>
                                            <th>Tombol</th>
                                            <th>Statistik</th>
                                            <th width="80" class="text-center">Status</th>
                                            <th width="120" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($slides as $slide)
                                            <tr>
                                                <td class="text-center align-middle">
                                                    <span class="badge badge-secondary">{{ $slide->sort_order }}</span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if ($slide->image)
                                                        <img src="{{ Storage::url($slide->image) }}" alt=""
                                                            class="rounded"
                                                            style="width:70px;height:45px;object-fit:cover;">
                                                    @else
                                                        <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                                            style="width:70px;height:45px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <small class="text-muted">{{ Str::limit($slide->badge, 35) }}</small>
                                                </td>
                                                <td class="align-middle">
                                                    <strong>{{ Str::limit(strip_tags($slide->title), 45) }}</strong>
                                                </td>
                                                <td class="align-middle">
                                                    @if ($slide->btn_primary_text)
                                                        <span
                                                            class="badge badge-primary d-block mb-1">{{ Str::limit($slide->btn_primary_text, 20) }}</span>
                                                    @endif
                                                    @if ($slide->btn_secondary_text)
                                                        <span
                                                            class="badge badge-secondary d-block">{{ Str::limit($slide->btn_secondary_text, 20) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @php $stats = is_array($slide->stats) ? $slide->stats : json_decode($slide->stats, true) ?? []; @endphp
                                                    @foreach ($stats as $st)
                                                        <small class="d-block">
                                                            <span
                                                                class="font-weight-bold text-primary">{{ $st['num'] ?? '' }}</span>
                                                            {{ $st['label'] ?? '' }}
                                                        </small>
                                                    @endforeach
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span
                                                        class="badge badge-{{ $slide->is_active ? 'success' : 'danger' }}">
                                                        {{ $slide->is_active ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <button class="btn btn-sm btn-warning btn-edit-slide mr-1"
                                                        data-id="{{ $slide->id }}" data-badge="{{ $slide->badge }}"
                                                        data-title="{{ $slide->title }}"
                                                        data-description="{{ $slide->description }}"
                                                        data-btn_primary="{{ $slide->btn_primary_text }}"
                                                        data-btn_secondary="{{ $slide->btn_secondary_text }}"
                                                        data-overlay="{{ $slide->overlay_color }}"
                                                        data-bg="{{ $slide->bg_color }}"
                                                        data-is_active="{{ $slide->is_active ? '1' : '0' }}"
                                                        data-stats="{{ json_encode($stats) }}" data-toggle="modal"
                                                        data-target="#modalEditSlide" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form
                                                        action="{{ route('admin.welcome-setting.slides.destroy', $slide) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Hapus slide ini?')">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5 text-muted">
                                                    <i class="fas fa-images fa-3x mb-3 d-block opacity-50"></i>
                                                    Belum ada slide. Klik <strong>"Tambah Slide Baru"</strong> untuk
                                                    memulai.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Tips:</strong> Urutan slide mengikuti kolom <em>No</em>.
                    </div>
                </div>

                {{-- ==================================================
                     TAB 3: PACKAGES
                ================================================== --}}
                <div class="tab-pane fade" id="tab-packages">
                    <ul class="nav nav-tabs mb-3" id="pkgTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#pkg-tab-umroh">
                                <i class="fas fa-kaaba text-primary mr-1"></i> Umroh
                                <span class="badge badge-primary ml-1">{{ $umroh->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pkg-tab-haji">
                                <i class="fas fa-mosque text-success mr-1"></i> Haji
                                <span class="badge badge-success ml-1">{{ $haji->count() }}</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        {{-- Umroh Packages --}}
                        <div class="tab-pane fade show active" id="pkg-tab-umroh">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-muted mb-0">Daftar Paket Umroh</h6>
                                <button class="btn btn-primary btn-sm" onclick="setPackageJenis('umroh')"
                                    data-toggle="modal" data-target="#modalAddPackage">
                                    <i class="fas fa-plus mr-1"></i> Tambah Paket Umroh
                                </button>
                            </div>
                            @include('admin.welcome-setting._package_table', ['packages' => $umroh])
                        </div>

                        {{-- Haji Packages --}}
                        <div class="tab-pane fade" id="pkg-tab-haji">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-muted mb-0">Daftar Paket Haji</h6>
                                <button class="btn btn-success btn-sm" onclick="setPackageJenis('haji')"
                                    data-toggle="modal" data-target="#modalAddPackage">
                                    <i class="fas fa-plus mr-1"></i> Tambah Paket Haji
                                </button>
                            </div>
                            @include('admin.welcome-setting._package_table', ['packages' => $haji])
                        </div>
                    </div>
                </div>

            </div>{{-- /tab-content --}}
        </div>
    </section>
@endsection


{{-- =========================================================
     MODALS — Di luar section agar tidak kena overflow Stisla
========================================================= --}}

{{-- MODAL: TAMBAH SLIDE --}}
<div class="modal fade" id="modalAddSlide" tabindex="-1" role="dialog" aria-labelledby="modalAddSlideLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.welcome-setting.slides.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalAddSlideLabel">
                        <i class="fas fa-plus mr-2"></i>Tambah Hero Slide
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('admin.welcome-setting._slide_form', ['slide' => null])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Slide
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL: EDIT SLIDE --}}
<div class="modal fade" id="modalEditSlide" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="formEditSlide" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>Edit Hero Slide
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    @include('admin.welcome-setting._slide_form', ['slide' => null, 'isEdit' => true])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i> Update Slide
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL: TAMBAH PAKET --}}
<div class="modal fade" id="modalAddPackage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.welcome-setting.packages.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus mr-2"></i>Tambah Paket
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('admin.welcome-setting._package_form', ['package' => null])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Paket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL: EDIT PAKET --}}
<div class="modal fade" id="modalEditPackage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditPackage" method="POST">
                @csrf @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>Edit Paket
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    @include('admin.welcome-setting._package_form', ['package' => null, 'isEdit' => true])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i> Update Paket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        /* =====================================================
           FIX MODAL STISLA — append modal ke body agar tidak
           kena overflow:hidden dari .main-content
        ===================================================== */
        $(document).ready(function() {
            // Pindahkan semua modal ke body level
            $('#modalAddSlide, #modalEditSlide, #modalAddPackage, #modalEditPackage').appendTo('body');

            // Fix: saat modal dibuka, body tidak kehilangan scroll
            $(document).on('show.bs.modal', '.modal', function() {
                $('body').css('overflow', 'auto');
            });
            $(document).on('hidden.bs.modal', '.modal', function() {
                $('body').css('overflow', '');
                // Hapus backdrop jika masih ada (bug Stisla)
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            });
        });

        /* =====================================================
           UTILITY: Image preview
        ===================================================== */
        function previewImg(input, targetId) {
            const target = document.getElementById(targetId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    target.src = e.target.result;
                    target.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
            const label = input.nextElementSibling;
            if (label && label.classList.contains('custom-file-label')) {
                label.textContent = input.files[0]?.name ?? 'Pilih file...';
            }
        }

        /* =====================================================
           SLIDE: Stat rows (Add / Remove)
        ===================================================== */
        function addStatRow(containerId) {
            const container = document.getElementById(containerId);
            const idx = container.querySelectorAll('.stat-row').length;
            const row = document.createElement('div');
            row.className = 'stat-row input-group mb-2';
            row.innerHTML = `
            <input type="text" name="stats[${idx}][num]" class="form-control form-control-sm" placeholder="Angka (mis: 12K+)">
            <input type="text" name="stats[${idx}][label]" class="form-control form-control-sm" placeholder="Label (mis: Jamaah)">
            <div class="input-group-append">
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="this.closest('.stat-row').remove(); renumberStats('${containerId}')">
                    <i class="fas fa-times"></i>
                </button>
            </div>`;
            container.appendChild(row);
        }

        function renumberStats(containerId) {
            document.querySelectorAll(`#${containerId} .stat-row`).forEach((row, i) => {
                row.querySelectorAll('input').forEach(inp => {
                    inp.name = inp.name.replace(/stats\[\d+\]/, `stats[${i}]`);
                });
            });
        }

        /* =====================================================
           PACKAGE: Feature rows (Add / Remove)
        ===================================================== */
        function addFeatureRow(containerId) {
            const container = document.getElementById(containerId);
            const idx = container.querySelectorAll('.feature-row').length;
            const row = document.createElement('div');
            row.className = 'feature-row input-group mb-2';
            row.innerHTML = `
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-check text-success"></i></span>
            </div>
            <input type="text" name="features[${idx}]" class="form-control form-control-sm" placeholder="Fitur paket...">
            <div class="input-group-append">
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="this.closest('.feature-row').remove(); renumberFeatures('${containerId}')">
                    <i class="fas fa-times"></i>
                </button>
            </div>`;
            container.appendChild(row);
        }

        function renumberFeatures(containerId) {
            document.querySelectorAll(`#${containerId} .feature-row`).forEach((row, i) => {
                const inp = row.querySelector('input[name^="features"]');
                if (inp) inp.name = `features[${i}]`;
            });
        }

        /* =====================================================
           EDIT SLIDE: populate modal dari data-* attribute
        ===================================================== */
        $(document).on('click', '.btn-edit-slide', function() {
            const id = this.dataset.id;
            const action = `{{ url('admin/welcome-setting/slides') }}/${id}`;
            $('#formEditSlide').attr('action', action);

            setVal('edit_badge', this.dataset.badge);
            setVal('edit_title', this.dataset.title);
            setVal('edit_description', this.dataset.description);
            setVal('edit_btn_primary', this.dataset.btn_primary);
            setVal('edit_btn_secondary', this.dataset.btn_secondary);
            setVal('edit_overlay_color', this.dataset.overlay);
            setVal('edit_bg_color', this.dataset.bg);

            const activeChk = document.getElementById('edit_is_active');
            if (activeChk) activeChk.checked = (this.dataset.is_active === '1');

            // Isi stats
            const statsContainer = document.getElementById('editStatsContainer');
            if (statsContainer) {
                statsContainer.innerHTML = '';
                let stats = [];
                try {
                    stats = JSON.parse(this.dataset.stats || '[]');
                } catch (e) {}
                stats.forEach((st, i) => {
                    const row = document.createElement('div');
                    row.className = 'stat-row input-group mb-2';
                    row.innerHTML = `
                    <input type="text" name="stats[${i}][num]" class="form-control form-control-sm"
                        value="${escHtml(st.num || '')}" placeholder="Angka">
                    <input type="text" name="stats[${i}][label]" class="form-control form-control-sm"
                        value="${escHtml(st.label || '')}" placeholder="Label">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="this.closest('.stat-row').remove(); renumberStats('editStatsContainer')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>`;
                    statsContainer.appendChild(row);
                });
            }
        });

        /* =====================================================
           EDIT PACKAGE: populate modal dari data-* attribute
        ===================================================== */
        $(document).on('click', '.btn-edit-package', function() {
            const id = this.dataset.id;
            const action = `{{ url('admin/welcome-setting/packages') }}/${id}`;
            $('#formEditPackage').attr('action', action);

            setVal('epkg_jenis', this.dataset.jenis);
            setVal('epkg_name', this.dataset.name);
            setVal('epkg_badge', this.dataset.badge);
            setVal('epkg_price', this.dataset.price);
            setVal('epkg_duration', this.dataset.duration);
            setVal('epkg_hotel', this.dataset.hotel);

            const featChk = document.getElementById('epkg_is_featured');
            const activeChk = document.getElementById('epkg_is_active');
            if (featChk) featChk.checked = (this.dataset.is_featured === '1');
            if (activeChk) activeChk.checked = (this.dataset.is_active === '1');

            const container = document.getElementById('editFeaturesContainer');
            if (container) {
                container.innerHTML = '';
                let features = [];
                try {
                    features = JSON.parse(this.dataset.features || '[]');
                } catch (e) {}
                features.forEach((f, i) => {
                    const row = document.createElement('div');
                    row.className = 'feature-row input-group mb-2';
                    row.innerHTML = `
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-check text-success"></i></span>
                    </div>
                    <input type="text" name="features[${i}]" class="form-control form-control-sm"
                        value="${escHtml(f)}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="this.closest('.feature-row').remove(); renumberFeatures('editFeaturesContainer')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>`;
                    container.appendChild(row);
                });
            }
        });

        /* =====================================================
           PACKAGE: Set jenis saat buka modal Tambah
        ===================================================== */
        function setPackageJenis(jenis) {
            setTimeout(() => {
                const sel = document.getElementById('pkg_jenis');
                if (sel) sel.value = jenis;
            }, 200);
        }

        /* =====================================================
           HELPERS
        ===================================================== */
        function setVal(id, val) {
            const el = document.getElementById(id);
            if (el) el.value = val || '';
        }

        function escHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        /* =====================================================
           Keep active tab on reload (via hash)
        ===================================================== */
        (function() {
            const hash = window.location.hash;
            if (hash) {
                const tab = document.querySelector(`[data-toggle="pill"][href="${hash}"]`);
                if (tab) $(tab).tab('show');
            }
            $('[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                history.replaceState(null, null, e.target.getAttribute('href'));
            });
        })();
    </script>
@endpush
