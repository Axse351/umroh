<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembelianDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pembelian_details')->insert([
            [
                'pembelian_id' => 1,
                'produk_id' => 1,
                'qty' => 10,
                'harga_satuan' => 500000,
                'subtotal' => 5000000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
