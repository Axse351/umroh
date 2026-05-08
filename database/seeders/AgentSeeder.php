<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('agents')->insert([
            [
                'kode_agent' => 'AG001',
                'nama_agent' => 'PT Amanah Travel',
                'nama_pic' => 'Budi',
                'jenis' => 'keduanya',
                'no_telepon' => '0811111111',
                'komisi_persen' => 10,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
