<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokOpnameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stok_opnames')->insert([
            [
                'no_opname' => 'OPN001',
                'produk_id' => 1,
                'stok_sistem' => 100,
                'stok_fisik' => 98,
                'selisih' => -2,
                'tanggal_opname' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
