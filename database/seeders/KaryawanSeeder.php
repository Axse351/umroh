<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('karyawans')->insert([
            [
                'kode_karyawan' => 'KRY001',
                'nama_lengkap' => 'Ahmad Fauzi',
                'nik' => '3276010101010001',
                'jabatan' => 'Direktur',
                'divisi' => 'Management',
                'no_telepon' => '081234567890',
                'email' => 'direktur@example.com',
                'alamat' => 'Bandung',
                'tanggal_masuk' => now(),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
