<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_setorans_table.php
    public function up()
    {
        Schema::create('setorans', function (Blueprint $table) {
            $table->id();
            $table->string('no_setoran')->unique();
            $table->foreignId('tabungan_id')->constrained('tabungans')->onDelete('restrict');
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->decimal('jumlah_setor', 15, 2);
            $table->date('tanggal_setor');
            $table->enum('jenis', ['setor', 'tarik'])->default('setor');
            $table->enum('metode', ['tunai', 'transfer', 'debit', 'qris'])->default('tunai');
            $table->string('bukti_setor')->nullable();
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('diterima');
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
        Schema::dropIfExists('setorans');
    }
};
