<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_layanans_table.php
    public function up()
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_layanan')->unique();
            $table->string('nama_layanan');
            $table->enum('jenis', ['umroh', 'haji', 'keduanya'])->default('keduanya');
            $table->enum('kategori', [
                'visa',
                'asuransi',
                'vaksin',
                'manasik',
                'perlengkapan',
                'transportasi',
                'lainnya'
            ]);
            $table->decimal('harga', 15, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
