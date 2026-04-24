<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_pendaftarans_table.php
    public function up()
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran')->unique();
            $table->foreignId('jamaah_id')->constrained('jamaah')->onDelete('restrict');
            $table->foreignId('keberangkatan_id')->constrained('keberangkatans')->onDelete('restrict');
            $table->foreignId('agent_id')->nullable()->constrained('agents')->onDelete('set null');
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->onDelete('set null'); // marketing
            $table->enum('jenis', ['umroh', 'haji', 'haji_plus', 'haji_furoda']);
            $table->enum('tipe_kamar', ['double', 'triple', 'quad'])->default('quad');
            $table->decimal('harga_jual', 15, 2);
            $table->decimal('dp_minimal', 15, 2)->default(0);
            $table->date('tanggal_daftar');
            $table->date('batas_pelunasan')->nullable();
            $table->enum('status', [
                'draft',
                'konfirmasi',
                'dp_terbayar',
                'lunas',
                'berangkat',
                'selesai',
                'batal',
                'refund'
            ])->default('draft');
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
        Schema::dropIfExists('pendaftarans');
    }
};
