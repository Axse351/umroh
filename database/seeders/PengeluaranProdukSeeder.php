<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengeluaranProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengeluaran_produks')->insert([
            [
                'no_pengeluaran_produk' => 'PK001',
                'produk_id' => 1,
                'pendaftaran_id' => 1,
                'qty' => 2,
                'tanggal_keluar' => now(),
                'keperluan' => 'distribusi_jamaah',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
