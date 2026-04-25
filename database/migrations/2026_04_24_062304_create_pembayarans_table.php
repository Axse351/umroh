<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_pembayarans_table.php
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pembayaran')->unique();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('restrict');
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->onDelete('set null'); // kasir
            $table->decimal('jumlah_bayar', 15, 2);
            $table->date('tanggal_bayar');
            $table->enum('metode_bayar', ['tunai', 'transfer', 'debit', 'kredit', 'qris'])->default('transfer');
            $table->string('bank_tujuan')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('nama_pengirim')->nullable();
            $table->string('bukti_bayar')->nullable(); // foto bukti transfer
            $table->enum('jenis', ['dp', 'cicilan', 'pelunasan', 'lainnya'])->default('cicilan');
            $table->enum('status', ['pending', 'verifikasi', 'diterima', 'ditolak'])->default('pending');
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
        Schema::dropIfExists('pembayarans');
    }
};
