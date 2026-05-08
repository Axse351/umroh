<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'kode_supplier' => 'SUP001',
                'nama_supplier' => 'PT Souvenir Haji',
                'kategori' => 'souvenir',
                'no_telepon' => '0812121212',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
