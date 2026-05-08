<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TabunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tabungans')->insert([
            [
                'no_rekening_tabungan' => 'TAB001',
                'jamaah_id' => 1,
                'jenis' => 'umroh',
                'target_tabungan' => 30000000,
                'saldo' => 5000000,
                'tanggal_buka' => now(),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
