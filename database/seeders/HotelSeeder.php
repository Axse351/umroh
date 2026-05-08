<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hotels')->insert([
            [
                'kode_hotel' => 'HTL001',
                'nama_hotel' => 'Makkah Tower',
                'lokasi' => 'mekkah',
                'bintang' => 5,
                'jarak_ke_masjid_meter' => 100,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_hotel' => 'HTL002',
                'nama_hotel' => 'Madinah Inn',
                'lokasi' => 'madinah',
                'bintang' => 4,
                'jarak_ke_masjid_meter' => 200,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
