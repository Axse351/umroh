<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pembayarans')->insert([
            [
                'no_pembayaran' => 'BYR001',
                'pendaftaran_id' => 1,
                'jumlah_bayar' => 5000000,
                'tanggal_bayar' => now(),
                'metode_bayar' => 'transfer',
                'jenis' => 'dp',
                'status' => 'diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
