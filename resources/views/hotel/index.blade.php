@extends('layouts.app')
@section('title', 'Data Hotel')
@section('page-title', 'Data Hotel')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Hotel</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-hotel mr-1"></i> Data Hotel</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.hotel.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Tambah Hotel
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.hotel.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <select name="lokasi" class="form-control">
                                        <option value="">Semua Lokasi</option>
                                        <option value="mekkah" {{ $lokasi == 'mekkah' ? 'selected' : '' }}>Mekkah</option>
                                        <option value="madinah" {{ $lokasi == 'madinah' ? 'selected' : '' }}>Madinah
                                        </option>
                                        <option value="jeddah" {{ $lokasi == 'jeddah' ? 'selected' : '' }}>Jeddah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search mr-1"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Nama Hotel</th>
                                    <th>Lokasi</th>
                                    <th class="text-center">Bintang</th>
                                    <th>Jarak ke Masjid</th>
                                    <th>No. Telepon</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hotels as $i => $item)
                                    <tr>
                                        <td>{{ $hotels->firstItem() + $i }}</td>
                                        <td><code>{{ $item->kode_hotel }}</code></td>
                                        <td class="font-weight-bold">{{ $item->nama_hotel }}</td>
                                        <td>
                                            @php
                                                $lokasiColor =
                                                    [
                                                        'mekkah' => 'badge-success',
                                                        'madinah' => 'badge-primary',
                                                        'jeddah' => 'badge-warning',
                                                    ][$item->lokasi] ?? 'badge-secondary';
                                            @endphp
                                            <div class="badge {{ $lokasiColor }}">
                                                {{ ucfirst($item->lokasi) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @for ($s = 1; $s <= 5; $s++)
                                                <i class="fas fa-star {{ $s <= $item->bintang ? 'text-warning' : 'text-muted' }}"
                                                    style="font-size: 11px;"></i>
                                            @endfor
                                        </td>
                                        <td>
                                            {{ $item->jarak_ke_masjid_meter ? number_format($item->jarak_ke_masjid_meter) . ' m' : '-' }}
                                        </td>
                                        <td>{{ $item->no_telepon ?? '-' }}</td>
                                        <td>
                                            <div
                                                class="badge {{ $item->status == 'aktif' ? 'badge-success' : 'badge-secondary' }}">
                                                {{ ucfirst($item->status) }}
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('hotel.show', $item) }}" class="btn btn-sm btn-info btn-icon"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('hotel.edit', $item) }}"
                                                class="btn btn-sm btn-warning btn-icon" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('hotel.destroy', $item) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus hotel ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-icon"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i> Tidak ada data hotel.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($hotels->hasPages())
                    <div class="card-footer">
                        {{ $hotels->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
