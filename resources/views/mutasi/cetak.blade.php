<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutasi Pembayaran – {{ $jamaah->nama_lengkap }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            background: #fff;
            padding: 20px 30px;
        }

        /* ── HEADER ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header-left .company { font-size: 18px; font-weight: 700; color: #0d6efd; }
        .header-left .subtitle { font-size: 11px; color: #555; margin-top: 2px; }
        .header-right { text-align: right; }
        .header-right .doc-title { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .header-right .doc-date { font-size: 11px; color: #555; margin-top: 3px; }

        /* ── INFO JAMAAH ── */
        .jamaah-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 16px;
        }
        .jamaah-box .row { display: flex; gap: 24px; flex-wrap: wrap; }
        .jamaah-box .col { min-width: 160px; }
        .jamaah-box .label { font-size: 10px; color: #777; text-transform: uppercase; letter-spacing: .5px; }
        .jamaah-box .value { font-weight: 600; font-size: 12px; margin-top: 1px; }

        /* ── SUMMARY STRIP ── */
        .summary-strip {
            display: flex;
            gap: 0;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .summary-strip .item {
            flex: 1;
            text-align: center;
            padding: 10px 8px;
            border-right: 1px solid #dee2e6;
        }
        .summary-strip .item:last-child { border-right: none; }
        .summary-strip .amount { font-size: 14px; font-weight: 700; }
        .summary-strip .desc { font-size: 10px; color: #777; margin-top: 2px; }
        .blue { color: #0d6efd; }
        .green { color: #198754; }
        .orange { color: #fd7e14; }

        /* ── SECTION TITLE ── */
        .section-title {
            background: #0d6efd;
            color: #fff;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 4px 4px 0 0;
        }
        .section-title .badge-status {
            background: rgba(255,255,255,.25);
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
        }
        .section-meta { font-size: 10px; opacity: .85; }

        /* ── TABLE ── */
        .wrap-table {
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 4px 4px;
            overflow: hidden;
            margin-bottom: 16px;
        }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: #f1f3f5;
            padding: 7px 8px;
            text-align: left;
            font-size: 10.5px;
            color: #444;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
        }
        tbody td {
            padding: 7px 8px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tfoot td {
            padding: 7px 8px;
            background: #f8f9fa;
            font-weight: 700;
            border-top: 1px solid #dee2e6;
            font-size: 11px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .mono { font-family: 'Courier New', monospace; font-size: 10.5px; }
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            color: #fff;
        }
        .badge-warning  { background: #ffc107; color: #333; }
        .badge-info     { background: #0dcaf0; color: #333; }
        .badge-success  { background: #198754; }
        .badge-secondary{ background: #6c757d; }
        .badge-danger   { background: #dc3545; }
        .empty-row td   { text-align: center; color: #aaa; padding: 14px; font-style: italic; }

        /* ── SISA ROW ── */
        .sisa-row {
            background: #fff8e1;
            padding: 6px 12px;
            border: 1px solid #ffe082;
            border-top: none;
            border-radius: 0 0 4px 4px;
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            font-size: 11px;
            margin-bottom: 16px;
        }
        .sisa-row span { color: #555; }
        .sisa-row strong { color: #dc3545; }

        /* ── FOOTER ── */
        .footer {
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .footer .note { font-size: 10px; color: #888; max-width: 380px; line-height: 1.6; }
        .ttd { text-align: center; min-width: 160px; }
        .ttd .ttd-name { border-top: 1px solid #333; padding-top: 4px; margin-top: 52px; font-size: 11px; font-weight: 600; }
        .ttd .ttd-role { font-size: 10px; color: #666; }

        /* ── PRINT ── */
        @media print {
            body { padding: 10px 16px; }
            .no-print { display: none !important; }
            .wrap-table { page-break-inside: avoid; }
            .section-block { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

    {{-- Print Button (hidden on print) --}}
    <div class="no-print" style="margin-bottom:16px; display:flex; gap:8px;">
        <button onclick="window.print()"
            style="background:#0d6efd;color:#fff;border:none;padding:8px 18px;border-radius:5px;cursor:pointer;font-size:13px;">
            🖨️ Cetak / Simpan PDF
        </button>
        <button onclick="window.close()"
            style="background:#6c757d;color:#fff;border:none;padding:8px 18px;border-radius:5px;cursor:pointer;font-size:13px;">
            ✕ Tutup
        </button>
    </div>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <div class="company">{{ config('app.name', 'Travel Umroh & Haji') }}</div>
            <div class="subtitle">Laporan Mutasi Pembayaran Jamaah</div>
        </div>
        <div class="header-right">
            <div class="doc-title">Mutasi Pembayaran</div>
            <div class="doc-date">Dicetak: {{ now()->isoFormat('dddd, D MMMM Y – HH:mm') }}</div>
        </div>
    </div>

    {{-- INFO JAMAAH --}}
    <div class="jamaah-box">
        <div class="row">
            <div class="col">
                <div class="label">Nama Lengkap</div>
                <div class="value">{{ $jamaah->nama_lengkap }}</div>
            </div>
            <div class="col">
                <div class="label">No. Identitas</div>
                <div class="value mono">{{ $jamaah->no_identitas ?? '-' }}</div>
            </div>
            <div class="col">
                <div class="label">No. HP</div>
                <div class="value">{{ $jamaah->no_hp ?? '-' }}</div>
            </div>
            <div class="col">
                <div class="label">Jenis Kelamin</div>
                <div class="value">{{ $jamaah->jenis_kelamin ?? '-' }}</div>
            </div>
            <div class="col">
                <div class="label">Alamat</div>
                <div class="value">{{ $jamaah->alamat ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="summary-strip">
        <div class="item">
            <div class="amount blue">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</div>
            <div class="desc">Total Tagihan</div>
        </div>
        <div class="item">
            <div class="amount green">Rp {{ number_format($totalTerbayar, 0, ',', '.') }}</div>
            <div class="desc">Total Diterima</div>
        </div>
        <div class="item">
            <div class="amount {{ $sisaTagihan <= 0 ? 'green' : 'orange' }}">
                Rp {{ number_format(max($sisaTagihan, 0), 0, ',', '.') }}
            </div>
            <div class="desc">Sisa Tagihan</div>
        </div>
        <div class="item">
            <div class="amount blue">{{ $jamaah->pendaftarans->count() }}</div>
            <div class="desc">Pendaftaran</div>
        </div>
    </div>

    {{-- PER PENDAFTARAN --}}
    @foreach ($jamaah->pendaftarans as $pendaftaran)
        @php
            $subTotal = $pendaftaran->pembayarans->where('status', 'diterima')->sum('jumlah_bayar');
            $statusBadgeClass = $pendaftaran->status === 'lunas' ? 'badge-success' : 'badge-warning';
        @endphp

        <div class="section-block">
            <div class="section-title">
                <span>
                    📋 {{ $pendaftaran->no_pendaftaran }}
                    &nbsp;|&nbsp; Paket: {{ $pendaftaran->paket->nama_paket ?? '-' }}
                    &nbsp;|&nbsp; Total Harga: Rp {{ number_format($pendaftaran->total_harga, 0, ',', '.') }}
                </span>
                <span class="badge-status">{{ ucfirst($pendaftaran->status) }}</span>
            </div>

            <div class="wrap-table">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Metode</th>
                            <th>Bank / Pengirim</th>
                            <th>Status</th>
                            <th class="text-right">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftaran->pembayarans as $i => $bayar)
                            @php
                                $jenisBadge   = ['dp'=>'badge-warning','cicilan'=>'badge-info','pelunasan'=>'badge-success','lainnya'=>'badge-secondary'][$bayar->jenis] ?? 'badge-secondary';
                                $statusBadge2 = ['pending'=>'badge-secondary','verifikasi'=>'badge-warning','diterima'=>'badge-success','ditolak'=>'badge-danger'][$bayar->status] ?? 'badge-secondary';
                            @endphp
                            <tr style="{{ $bayar->status === 'ditolak' ? 'opacity:.5;' : '' }}">
                                <td>{{ $i + 1 }}</td>
                                <td class="mono">{{ $bayar->no_pembayaran }}</td>
                                <td>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->isoFormat('D MMM Y') }}</td>
                                <td><span class="badge {{ $jenisBadge }}">{{ ucfirst($bayar->jenis) }}</span></td>
                                <td>{{ ucfirst($bayar->metode_bayar) }}</td>
                                <td>
                                    {{ $bayar->bank_tujuan ?? '' }}
                                    @if($bayar->nama_pengirim)
                                        <br><small style="color:#888;">{{ $bayar->nama_pengirim }}</small>
                                    @endif
                                </td>
                                <td><span class="badge {{ $statusBadge2 }}">{{ ucfirst($bayar->status) }}</span></td>
                                <td class="text-right" style="{{ $bayar->status === 'diterima' ? 'color:#198754;font-weight:700;' : '' }}">
                                    {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="8">Belum ada transaksi pembayaran untuk pendaftaran ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($pendaftaran->pembayarans->isNotEmpty())
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-right">Subtotal Diterima</td>
                                <td class="text-right" style="color:#198754;">
                                    {{ number_format($subTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            <div class="sisa-row">
                <span>Total Tagihan:
                    <strong style="color:#0d6efd;">Rp {{ number_format($pendaftaran->total_harga, 0, ',', '.') }}</strong>
                </span>
                <span>Terbayar:
                    <strong style="color:#198754;">Rp {{ number_format($subTotal, 0, ',', '.') }}</strong>
                </span>
                <span>Sisa:
                    <strong>Rp {{ number_format(max($pendaftaran->sisa_tagihan, 0), 0, ',', '.') }}</strong>
                </span>
            </div>
        </div>
    @endforeach

    {{-- FOOTER --}}
    <div class="footer">
        <div class="note">
            Dokumen ini merupakan rekap mutasi pembayaran yang dihasilkan secara otomatis oleh sistem.<br>
            Sah tanpa tanda tangan basah apabila dicetak dari sistem resmi.
        </div>
        <div class="ttd">
            <div class="ttd-name">Petugas / Admin</div>
            <div class="ttd-role">{{ auth()->user()->name ?? '____________________' }}</div>
        </div>
    </div>

</body>
</html>
