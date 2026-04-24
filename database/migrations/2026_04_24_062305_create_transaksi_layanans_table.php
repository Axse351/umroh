<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_transaksi_layanans_table.php
    public function up()
    {
        Schema::create('transaksi_layanans', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('restrict');
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('restrict');
            $table->integer('qty')->default(1);
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->date('tanggal_transaksi');
            $table->enum('status', ['pending', 'proses', 'selesai', 'batal'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_layanans');
    }
};
