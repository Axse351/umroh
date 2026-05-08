<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetoranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setorans')->insert([
            [
                'no_setoran' => 'STR001',
                'tabungan_id' => 1,
                'jumlah_setor' => 1000000,
                'tanggal_setor' => now(),
                'jenis' => 'setor',
                'metode' => 'transfer',
                'status' => 'diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
