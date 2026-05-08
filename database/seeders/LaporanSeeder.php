<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('laporans')->insert([
            [
                'judul' => 'Laporan Keuangan Bulanan',
                'jenis' => 'keuangan',
                'periode_dari' => now()->startOfMonth(),
                'periode_sampai' => now()->endOfMonth(),
                'data' => json_encode([
                    'pemasukan' => 100000000,
                    'pengeluaran' => 70000000
                ]),
                'status' => 'final',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
