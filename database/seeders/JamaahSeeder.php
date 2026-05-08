<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JamaahSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jamaah')->insert([
            [
                'kode_jamaah' => 'JMH001',
                'nama_lengkap' => 'Muhammad Rizki',
                'nik' => '3276010101010002',
                'jenis_kelamin' => 'laki-laki',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1995-01-01',
                'alamat' => 'Bandung',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'no_telepon' => '081234567891',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
