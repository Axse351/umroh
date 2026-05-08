<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pendaftarans')->insert([
            [
                'no_pendaftaran' => 'PDF001',
                'jamaah_id' => 1,
                'keberangkatan_id' => 1,
                'agent_id' => 1,
                'jenis' => 'umroh',
                'tipe_kamar' => 'quad',
                'harga_jual' => 30000000,
                'dp_minimal' => 5000000,
                'tanggal_daftar' => now(),
                'status' => 'dp_terbayar',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
