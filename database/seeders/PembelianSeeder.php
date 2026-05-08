<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pembelians')->insert([
            [
                'no_pembelian' => 'PBL001',
                'supplier_id' => 1,
                'tanggal_beli' => now(),
                'total' => 5000000,
                'status' => 'diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
