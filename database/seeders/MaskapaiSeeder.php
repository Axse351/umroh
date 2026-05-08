<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaskapaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('maskapais')->insert([
            [
                'kode_maskapai' => 'MSK001',
                'nama_maskapai' => 'Garuda Indonesia',
                'kode_iata' => 'GA',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
