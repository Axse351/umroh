<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemasukanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pemasukans')->insert([
            [
                'no_pemasukan' => 'PMK001',
                'sumber' => 'Pembayaran Jamaah',
                'kategori' => 'pembayaran_jamaah',
                'jumlah' => 5000000,
                'tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
