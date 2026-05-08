<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produks')->insert([
            [
                'kode_produk' => 'PRD001',
                'nama_produk' => 'Koper Umroh',
                'kategori' => 'koper',
                'supplier_id' => 1,
                'stok' => 100,
                'harga_beli' => 500000,
                'harga_jual' => 700000,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
