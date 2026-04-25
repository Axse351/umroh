<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_dokumens_table.php
    public function up()
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('restrict');
            $table->foreignId('jamaah_id')->constrained('jamaah')->onDelete('restrict');
            $table->enum('jenis_dokumen', [
                'ktp',
                'passport',
                'foto',
                'kartu_keluarga',
                'akta_lahir',
                'buku_nikah',
                'surat_mahram',
                'surat_kesehatan',
                'visa',
                'bukti_vaksin',
                'lainnya'
            ]);
            $table->string('file_path');
            $table->string('nama_file');
            $table->date('tanggal_upload');
            $table->date('tanggal_expired')->nullable();
            $table->enum('status', ['pending', 'valid', 'expired', 'ditolak'])->default('pending');
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
        Schema::dropIfExists('dokumens');
    }
};
