<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_pemasukans_table.php
    public function up()
    {
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pemasukan')->unique();
            $table->string('sumber'); // sumber pemasukan
            $table->enum('kategori', [
                'pembayaran_jamaah',
                'setoran_tabungan',
                'transaksi_layanan',
                'komisi',
                'lainnya'
            ]);
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};
