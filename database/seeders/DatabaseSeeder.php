<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KaryawanSeeder::class,
            JamaahSeeder::class,
            AgentSeeder::class,
            HotelSeeder::class,
            LayananSeeder::class,
            MaskapaiSeeder::class,
            MitraSeeder::class,
            PaketSeeder::class,
            KeberangkatanSeeder::class,
            PendaftaranSeeder::class,
            PembayaranSeeder::class,
            TabunganSeeder::class,
            SetoranSeeder::class,
            SupplierSeeder::class,
            ProdukSeeder::class,
            PembelianSeeder::class,
            PembelianDetailSeeder::class,
            PengeluaranProdukSeeder::class,
            StokOpnameSeeder::class,
            PengeluaranSeeder::class,
            PemasukanSeeder::class,
            TransaksiLayananSeeder::class,
            LaporanSeeder::class,
        ]);
    }
}
