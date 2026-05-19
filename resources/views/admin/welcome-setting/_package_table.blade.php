{{-- resources/views/admin/welcome-setting/_package_table.blade.php --}}
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Hotel</th>
                        <th>Fitur</th>
                        <th width="100" class="text-center">Badge</th>
                        <th width="80" class="text-center">Status</th>
                        <th width="120" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $pkg)
                        @php
                            $features = is_array($pkg->features)
                                ? $pkg->features
                                : json_decode($pkg->features ?? '[]', true) ?? [];
                        @endphp
                        <tr>
                            <td class="text-center align-middle">{{ $pkg->sort_order }}</td>
                            <td class="align-middle">
                                <strong>{{ $pkg->name }}</strong>
                                @if ($pkg->is_featured)
                                    <span class="badge badge-warning ml-1"><i class="fas fa-star"></i> Featured</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <span class="text-primary font-weight-bold">{{ $pkg->price }}</span>
                            </td>
                            <td class="align-middle">{{ $pkg->duration }}</td>
                            <td class="align-middle"><small>{{ $pkg->hotel }}</small></td>
                            <td class="align-middle">
                                <small class="text-muted">
                                    @foreach (array_slice($features, 0, 3) as $f)
                                        <i class="fas fa-check text-success mr-1"></i>{{ $f }}<br>
                                    @endforeach
                                    @if (count($features) > 3)
                                        <span class="text-muted">+{{ count($features) - 3 }} lainnya</span>
                                    @endif
                                </small>
                            </td>
                            <td class="text-center align-middle">
                                @if ($pkg->badge)
                                    <span class="badge badge-warning">{{ $pkg->badge }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge badge-{{ $pkg->is_active ? 'success' : 'danger' }}">
                                    {{ $pkg->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <button class="btn btn-sm btn-warning btn-edit-package mr-1"
                                    data-id="{{ $pkg->id }}" data-jenis="{{ $pkg->jenis }}"
                                    data-name="{{ $pkg->name }}" data-badge="{{ $pkg->badge }}"
                                    data-price="{{ $pkg->price }}" data-duration="{{ $pkg->duration }}"
                                    data-hotel="{{ $pkg->hotel }}"
                                    data-is_featured="{{ $pkg->is_featured ? '1' : '0' }}"
                                    data-is_active="{{ $pkg->is_active ? '1' : '0' }}"
                                    data-features="{{ json_encode($features) }}" data-toggle="modal"
                                    data-target="#modalEditPackage" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.welcome-setting.packages.destroy', $pkg) }}"
                                    method="POST" class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3 d-block opacity-50"></i>
                                Belum ada paket. Klik tombol <strong>"Tambah Paket"</strong> di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
