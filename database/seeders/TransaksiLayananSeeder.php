<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaksi_layanans')->insert([
            [
                'no_transaksi' => 'TRL001',
                'pendaftaran_id' => 1,
                'layanan_id' => 1,
                'qty' => 1,
                'harga_satuan' => 1500000,
                'total_harga' => 1500000,
                'tanggal_transaksi' => now(),
                'status' => 'selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
