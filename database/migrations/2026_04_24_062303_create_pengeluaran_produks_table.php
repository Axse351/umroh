<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_pengeluaran_produks_table.php
    public function up()
    {
        Schema::create('pengeluaran_produks', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengeluaran_produk')->unique();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('restrict');
            $table->foreignId('pendaftaran_id')->nullable()->constrained('pendaftarans')->onDelete('set null');
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->integer('qty');
            $table->date('tanggal_keluar');
            $table->enum('keperluan', ['distribusi_jamaah', 'internal', 'rusak', 'lainnya'])->default('distribusi_jamaah');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_produks');
    }
};
