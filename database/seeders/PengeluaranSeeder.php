<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengeluarans')->insert([
            [
                'no_pengeluaran' => 'PNG001',
                'keperluan' => 'Bayar Hotel',
                'kategori' => 'hotel',
                'jumlah' => 20000000,
                'tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
