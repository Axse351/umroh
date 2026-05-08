<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Mutasi Pembayaran — {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #111;
            background: #fff;
        }

        /* ── Print tombol (hanya tampil di layar) ── */
        .print-action {
            position: fixed;
            top: 16px;
            right: 16px;
            z-index: 999;
            display: flex;
            gap: 8px;
        }

        .print-action button,
        .print-action a {
            padding: 8px 18px;
            border-radius: 7px;
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background: #1c3d8f;
            color: #fff;
        }

        .btn-back {
            background: #f0f1f7;
            color: #333;
        }

        @media print {
            .print-action {
                display: none !important;
            }
        }

        /* ── Kertas ── */
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 16mm 18mm 20mm;
            background: #fff;
        }

        @media print {
            body {
                margin: 0;
            }

            .page {
                width: 100%;
                margin: 0;
                padding: 14mm 16mm 18mm;
                box-shadow: none;
            }

            @page {
                size: A4;
                margin: 0;
            }
        }

        @media screen {
            body {
                background: #e5e7eb;
                padding: 24px 0 40px;
            }

            .page {
                box-shadow: 0 2px 24px rgba(0, 0, 0, .13);
            }
        }

        /* ═══════════════════════════════
           HEADER / KOP SURAT
        ═══════════════════════════════ */
        .kop {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 8px;
            border-bottom: 2.5px solid #8B6914;
        }

        .kop-logo {
            width: 64px;
            height: 64px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .kop-middle {
            flex: 1;
            padding: 0 14px;
        }

        .kop-company {
            font-size: 15pt;
            font-weight: 700;
            color: #1c3d8f;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .kop-tagline {
            font-size: 9.5pt;
            color: #555;
            font-style: italic;
            margin-top: 1px;
        }

        .kop-right {
            text-align: right;
            font-size: 8pt;
            color: #444;
            line-height: 1.5;
        }

        .kop-address {
            background: #8B6914;
            color: #fff;
            font-size: 8pt;
            text-align: center;
            padding: 4px 8px;
            margin-top: 6px;
            letter-spacing: .2px;
        }

        /* ═══════════════════════════════
           JUDUL DOKUMEN
        ═══════════════════════════════ */
        .doc-title {
            text-align: center;
            margin: 18px 0 14px;
        }

        .doc-title h2 {
            font-size: 13pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1.5px solid #111;
            display: inline-block;
            padding-bottom: 3px;
        }

        /* ═══════════════════════════════
           META INFO
        ═══════════════════════════════ */
        .meta-info {
            margin-bottom: 14px;
            font-size: 10pt;
            line-height: 1.7;
        }

        .meta-info .row {
            display: flex;
        }

        .meta-info .label {
            width: 140px;
            flex-shrink: 0;
        }

        .meta-info .colon {
            margin-right: 6px;
        }

        .meta-info .val {
            font-weight: 700;
        }

        /* ═══════════════════════════════
           DATA TRAVEL & JAMAAH (dua kolom)
        ═══════════════════════════════ */
        .data-section {
            display: flex;
            gap: 0;
            margin-bottom: 14px;
            border: 1px solid #ccc;
        }

        .data-col {
            flex: 1;
            padding: 10px 14px;
            font-size: 9.5pt;
            line-height: 1.65;
        }

        .data-col:first-child {
            border-right: 1px solid #ccc;
        }

        .data-col-title {
            font-size: 8.5pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #444;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }

        .data-col strong {
            display: block;
            font-size: 10pt;
            margin-bottom: 2px;
        }

        /* ═══════════════════════════════
           TABEL RINGKASAN PENDAFTARAN
        ═══════════════════════════════ */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 10pt;
        }

        .summary-table th {
            background: #f0f1f5;
            border: 1px solid #bbb;
            padding: 6px 10px;
            font-weight: 700;
            text-align: left;
            font-size: 9pt;
        }

        .summary-table td {
            border: 1px solid #bbb;
            padding: 6px 10px;
            vertical-align: top;
        }

        /* ═══════════════════════════════
           KOTAK TOTAL
        ═══════════════════════════════ */
        .totals {
            display: flex;
            gap: 0;
            margin-bottom: 14px;
            border: 1px solid #bbb;
        }

        .total-box {
            flex: 1;
            padding: 8px 14px;
            font-size: 10pt;
        }

        .total-box:not(:last-child) {
            border-right: 1px solid #bbb;
        }

        .total-box-label {
            font-size: 8.5pt;
            font-weight: 700;
            text-transform: uppercase;
            color: #555;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
            margin-bottom: 4px;
        }

        .total-box-val {
            font-size: 11.5pt;
            font-weight: 700;
            color: #1c3d8f;
        }

        .total-box-val.danger {
            color: #b91c1c;
        }

        .total-box-val.success {
            color: #15803d;
        }

        .total-box-val.warning {
            color: #b45309;
        }

        /* ═══════════════════════════════
           TABEL MUTASI PEMBAYARAN
        ═══════════════════════════════ */
        .mutasi-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9.5pt;
        }

        .mutasi-table thead tr {
            background: #1c3d8f;
            color: #fff;
        }

        .mutasi-table th {
            padding: 7px 10px;
            text-align: left;
            font-size: 9pt;
            font-weight: 600;
            border: 1px solid #1c3d8f;
        }

        .mutasi-table td {
            padding: 6px 10px;
            border: 1px solid #d0d0d0;
            vertical-align: middle;
        }

        .mutasi-table tbody tr:nth-child(even) {
            background: #f7f8fc;
        }

        .mutasi-table .status-confirmed {
            color: #15803d;
            font-weight: 600;
        }

        .mutasi-table .status-pending {
            color: #b45309;
            font-weight: 600;
        }

        .mutasi-table .status-ditolak {
            color: #b91c1c;
            font-weight: 600;
        }

        .mutasi-table .status-verifikasi {
            color: #1d4ed8;
            font-weight: 600;
        }

        .mutasi-table .jenis-dp {
            color: #b45309;
        }

        .mutasi-table .jenis-cicilan {
            color: #1d4ed8;
        }

        .mutasi-table .jenis-pelunasan {
            color: #15803d;
        }

        .mutasi-table .jenis-lainnya {
            color: #555;
        }

        .mutasi-table tfoot td {
            font-weight: 700;
            background: #f0f1f5;
            border: 1px solid #bbb;
            padding: 7px 10px;
        }

        /* ═══════════════════════════════
           TANDA TANGAN
        ═══════════════════════════════ */
        .ttd-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .ttd-box {
            text-align: center;
            font-size: 10pt;
            width: 200px;
        }

        .ttd-box .ttd-place-date {
            margin-bottom: 4px;
        }

        .ttd-box .ttd-company {
            font-weight: 700;
            margin-bottom: 60px;
        }

        .ttd-box .ttd-name {
            font-weight: 700;
            border-top: 1px solid #333;
            padding-top: 3px;
        }

        .ttd-box .ttd-position {
            font-size: 9pt;
            color: #555;
        }

        /* ═══════════════════════════════
           FOOTER HALAMAN
        ═══════════════════════════════ */
        .page-footer {
            margin-top: 24px;
            padding-top: 8px;
            border-top: 1px solid #ccc;
            font-size: 7.5pt;
            color: #888;
            text-align: center;
        }

        /* ── Badge status pendaftaran ── */
        .badge-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 8.5pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .badge-lunas {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-dp {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-draft {
            background: #f1f5f9;
            color: #475569;
        }

        .badge-konfirmasi {
            background: #e0f2fe;
            color: #0369a1;
        }

        .badge-batal {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-berangkat {
            background: #1c1c2e;
            color: #fff;
        }

        .badge-selesai {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-refund {
            background: #fef9c3;
            color: #854d0e;
        }
    </style>
</head>

<body>

    {{-- ── Tombol aksi (hanya di layar) ── --}}
    <div class="print-action">
        <a href="{{ route('admin.pendaftaran.show', $pendaftaran) }}" class="btn-back">← Kembali</a>
        <button class="btn-print" onclick="window.print()">🖨 Cetak / Simpan PDF</button>
    </div>

    <div class="page">

        {{-- ══ KOP SURAT ══ --}}
        <div class="kop">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="kop-logo">
            <div class="kop-middle">
                <div class="kop-company">Genmim Travel</div>
                <div class="kop-tagline">Tour and Travel — Haji & Umroh</div>
            </div>
            <div class="kop-right">
                <div>Telp: {{ config('app.telp', '-') }}</div>
                <div>Fax: {{ config('app.fax', '-') }}</div>
                <div>Email: {{ config('app.email', '-') }}</div>
            </div>
        </div>
        <div class="kop-address">
            {{ config('app.address', 'Jl. —, Indonesia') }}
        </div>

        {{-- ══ JUDUL ══ --}}
        <div class="doc-title">
            <h2>Riwayat Mutasi Pembayaran Pendaftaran</h2>
        </div>

        {{-- ══ META INFO ══ --}}
        @php
            $statusBadgeMap = [
                'lunas' => 'badge-lunas',
                'dp_terbayar' => 'badge-dp',
                'draft' => 'badge-draft',
                'konfirmasi' => 'badge-konfirmasi',
                'batal' => 'badge-batal',
                'berangkat' => 'badge-berangkat',
                'selesai' => 'badge-selesai',
                'refund' => 'badge-refund',
            ];
            $statusBadgeClass = $statusBadgeMap[$pendaftaran->status] ?? 'badge-draft';
        @endphp
        <div class="meta-info">
            <div class="row">
                <span class="label">Tanggal Cetak</span>
                <span class="colon">:</span>
                <span class="val">{{ now()->translatedFormat('d F Y') }}</span>
            </div>
            <div class="row">
                <span class="label">Kode Mutasi</span>
                <span class="colon">:</span>
                <span class="val">{{ $pendaftaran->no_pendaftaran }}/MUT/{{ now()->format('Ymd') }}</span>
            </div>
            <div class="row">
                <span class="label">Status Pendaftaran</span>
                <span class="colon">:</span>
                <span class="val">
                    <span class="badge-status {{ $statusBadgeClass }}">
                        {{ ucfirst(str_replace('_', ' ', $pendaftaran->status)) }}
                    </span>
                </span>
            </div>
        </div>

        {{-- ══ DATA TRAVEL & JAMAAH ══ --}}
        <div class="data-section">
            <div class="data-col">
                <div class="data-col-title">Data Travel</div>
                <strong>Genmim Travel</strong>
                {{ config('app.address', 'Jl. —, Indonesia') }}<br>
                Telp: {{ config('app.telp', '-') }}<br>
                Email: {{ config('app.email', '-') }}
            </div>
            <div class="data-col">
                <div class="data-col-title">Data Jamaah</div>
                <strong>{{ $pendaftaran->jamaah->nama_lengkap ?? '-' }}</strong>
                {{ $pendaftaran->jamaah->alamat ?? '-' }}<br>
                Telp: {{ $pendaftaran->jamaah->no_telepon ?? '-' }}<br>
                Email: {{ $pendaftaran->jamaah->email ?? '-' }}
            </div>
        </div>

        {{-- ══ TABEL RINGKASAN PENDAFTARAN ══ --}}
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Tgl. Daftar</th>
                    <th>No. Pendaftaran</th>
                    <th>Paket</th>
                    <th>Jenis</th>
                    <th>Tipe Kamar</th>
                    <th>Tgl. Berangkat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar ?? $pendaftaran->created_at)->translatedFormat('d F Y') }}
                    </td>
                    <td><strong>{{ $pendaftaran->no_pendaftaran }}</strong></td>
                    <td>{{ $pendaftaran->keberangkatan->paket->nama_paket ?? '-' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $pendaftaran->jenis)) }}</td>
                    <td>{{ ucfirst($pendaftaran->tipe_kamar ?? '-') }}</td>
                    <td>{{ $pendaftaran->keberangkatan->tanggal_berangkat
                        ? \Carbon\Carbon::parse($pendaftaran->keberangkatan->tanggal_berangkat)->translatedFormat('d F Y')
                        : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- ══ KOTAK TOTAL ══ --}}
        @php
            /* Hanya hitung pembayaran yang sudah diterima */
            $totalDiterima = $pembayarans->where('status', 'diterima')->sum('jumlah_bayar');

            /* Semua pembayaran masuk (termasuk pending/verifikasi) */
            $totalMasuk = $pembayarans->sum('jumlah_bayar');

            $hargaJual = (float) ($pendaftaran->harga_jual ?? 0);
            $sisaTagihan = max(0, $hargaJual - $totalDiterima);
            $dpMinimal = (float) ($pendaftaran->dp_minimal ?? 0);
        @endphp

        <div class="totals">
            <div class="total-box">
                <div class="total-box-label">Harga Paket</div>
                <div class="total-box-val">Rp {{ number_format($hargaJual, 0, ',', '.') }}</div>
            </div>
            <div class="total-box">
                <div class="total-box-label">DP Minimal</div>
                <div class="total-box-val warning">Rp {{ number_format($dpMinimal, 0, ',', '.') }}</div>
            </div>
            <div class="total-box">
                <div class="total-box-label">Total Terbayar</div>
                <div class="total-box-val success">Rp {{ number_format($totalDiterima, 0, ',', '.') }}</div>
            </div>
            <div class="total-box">
                <div class="total-box-label">Sisa Tagihan</div>
                <div class="total-box-val {{ $sisaTagihan > 0 ? 'danger' : 'success' }}">
                    {{ $sisaTagihan > 0 ? 'Rp ' . number_format($sisaTagihan, 0, ',', '.') : 'LUNAS' }}
                </div>
            </div>
        </div>

        {{-- ══ TABEL MUTASI PEMBAYARAN ══ --}}
        <table class="mutasi-table">
            <thead>
                <tr>
                    <th style="width:28px;">No</th>
                    <th>Tanggal</th>
                    <th>No. Pembayaran</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Bank / Rek.</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembayarans as $i => $p)
                    @php
                        /* Status */
                        $statusClass = match ($p->status ?? '') {
                            'diterima' => 'status-confirmed',
                            'verifikasi' => 'status-verifikasi',
                            'pending' => 'status-pending',
                            'ditolak' => 'status-ditolak',
                            default => '',
                        };
                        $statusLabel = match ($p->status ?? '') {
                            'diterima' => 'Confirmed',
                            'verifikasi' => 'Verifikasi',
                            'pending' => 'Pending',
                            'ditolak' => 'Ditolak',
                            default => ucfirst($p->status ?? '-'),
                        };

                        /* Jenis pembayaran */
                        $jenisClass = match ($p->jenis ?? '') {
                            'dp' => 'jenis-dp',
                            'cicilan' => 'jenis-cicilan',
                            'pelunasan' => 'jenis-pelunasan',
                            default => 'jenis-lainnya',
                        };
                        $jenisLabel = match ($p->jenis ?? '') {
                            'dp' => 'DP',
                            'cicilan' => 'Cicilan',
                            'pelunasan' => 'Pelunasan',
                            'lainnya' => 'Lainnya',
                            default => ucfirst($p->jenis ?? '-'),
                        };

                        $bankInfo = collect([$p->bank_tujuan, $p->no_rekening])
                            ->filter()
                            ->implode(' / ');
                    @endphp
                    <tr>
                        <td style="text-align:center;">{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar ?? $p->created_at)->translatedFormat('d F Y') }}
                        </td>
                        <td style="font-size:8.5pt; color:#555;">{{ $p->no_pembayaran ?? '-' }}</td>
                        <td class="{{ $jenisClass }}"><strong>{{ $jenisLabel }}</strong></td>
                        <td><strong>Rp {{ number_format($p->jumlah_bayar ?? 0, 0, ',', '.') }}</strong></td>
                        <td>{{ ucfirst($p->metode_bayar ?? '-') }}</td>
                        <td style="font-size:8.5pt; color:#555;">{{ $bankInfo ?: '-' }}</td>
                        <td class="{{ $statusClass }}">{{ $statusLabel }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; color:#888; font-style:italic; padding:14px;">
                            Belum ada riwayat pembayaran
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if ($pembayarans->count() > 0)
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;">Total Pembayaran Diterima :</td>
                        <td colspan="4">Rp {{ number_format($totalDiterima, 0, ',', '.') }}</td>
                    </tr>
                    @if ($sisaTagihan > 0)
                        <tr>
                            <td colspan="4" style="text-align:right;">Sisa Tagihan :</td>
                            <td colspan="4" style="color:#b91c1c;">
                                Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endif
                </tfoot>
            @endif
        </table>

        {{-- ══ TANDA TANGAN ══ --}}
        <div class="ttd-section">
            <div class="ttd-box">
                <div class="ttd-place-date">
                    {{ config('app.city', 'Jakarta') }}, {{ now()->translatedFormat('d F Y') }}
                </div>
                <div class="ttd-company">{{ config('app.name', 'Genmim Travel') }}</div>
                <div class="ttd-name">{{ config('app.director', 'Direktur Utama') }}</div>
                <div class="ttd-position">Direktur Utama</div>
            </div>
        </div>

        {{-- ══ FOOTER ══ --}}
        <div class="page-footer">
            Dokumen ini dicetak secara otomatis oleh sistem &bull; {{ config('app.name') }} &bull;
            {{ now()->format('d/m/Y H:i') }}
        </div>

    </div>

</body>

</html>
