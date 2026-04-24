<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_pengeluarans_table.php
    public function up()
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengeluaran')->unique();
            $table->string('keperluan');
            $table->enum('kategori', [
                'operasional',
                'gaji',
                'visa',
                'tiket',
                'hotel',
                'transportasi',
                'perlengkapan',
                'marketing',
                'lainnya'
            ]);
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal');
            $table->string('penerima')->nullable();
            $table->string('bukti')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('pengeluarans');
    }
};
