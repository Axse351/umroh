<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pakets')->insert([
            [
                'kode_paket' => 'PKT001',
                'nama_paket' => 'Umroh Ramadhan',
                'jenis' => 'umroh',
                'kategori' => 'vip',
                'durasi_hari' => 12,
                'maskapai_id' => 1,
                'hotel_mekkah_id' => 1,
                'hotel_madinah_id' => 2,
                'kapasitas' => 45,
                'harga_double' => 35000000,
                'harga_triple' => 32000000,
                'harga_quad' => 30000000,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
