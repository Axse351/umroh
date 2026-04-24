<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_laporans_table.php
    public function up()
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('jenis', [
                'keuangan',
                'jamaah_umroh',
                'jamaah_haji',
                'tabungan',
                'stok',
                'pembayaran',
                'keberangkatan',
                'lainnya'
            ]);
            $table->date('periode_dari')->nullable();
            $table->date('periode_sampai')->nullable();
            $table->json('data')->nullable();
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->string('file_path')->nullable();
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
