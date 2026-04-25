@extends('layouts.app')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Sistem')
@section('breadcrumb')
    <div class="breadcrumb-item active">Setting</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-cog mr-2"></i>Pengaturan Umum</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <h6 class="text-primary mb-3">Informasi Perusahaan</h6>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Nama Perusahaan <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_perusahaan" class="form-control"
                                        value="{{ \App\Models\Setting::get('nama_perusahaan', 'Travel Umroh & Haji') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Logo</label>
                                    @php $logo = \App\Models\Setting::get('logo'); @endphp
                                    @if ($logo)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $logo) }}" class="img-thumbnail"
                                                style="max-height:60px">
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" name="logo" class="custom-file-input" id="logo"
                                            accept="image/*"
                                            onchange="this.nextElementSibling.textContent=this.files[0].name">
                                        <label class="custom-file-label" for="logo">Ganti logo...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                        value="{{ \App\Models\Setting::get('no_telepon') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ \App\Models\Setting::get('email') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="url" name="website" class="form-control"
                                        value="{{ \App\Models\Setting::get('website') }}" placeholder="https://...">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3">{{ \App\Models\Setting::get('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-primary mb-3">Pengaturan Pembayaran</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DP Minimal (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="dp_minimal_persen" class="form-control"
                                            value="{{ \App\Models\Setting::get('dp_minimal_persen', 30) }}" min="0"
                                            max="100">
                                        <div class="input-group-append"><span class="input-group-text">%</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan
                                Pengaturan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Info Sistem</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td>Laravel</td>
                            <td><span class="badge badge-success">{{ app()->version() }}</span></td>
                        </tr>
                        <tr>
                            <td>PHP</td>
                            <td><span class="badge badge-info">{{ phpversion() }}</span></td>
                        </tr>
                        <tr>
                            <td>Environment</td>
                            <td><span
                                    class="badge badge-{{ app()->isProduction() ? 'danger' : 'warning' }}">{{ app()->environment() }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Timezone</td>
                            <td>{{ config('app.timezone') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
