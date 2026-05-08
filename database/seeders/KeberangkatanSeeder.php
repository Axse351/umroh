<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeberangkatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('keberangkatans')->insert([
            [
                'kode_keberangkatan' => 'KB001',
                'paket_id' => 1,
                'tanggal_berangkat' => now(),
                'tanggal_pulang' => now()->addDays(12),
                'kuota' => 45,
                'harga_double' => 35000000,
                'harga_triple' => 32000000,
                'harga_quad' => 30000000,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
