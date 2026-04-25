<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_keberangkatans_table.php
    public function up()
    {
        Schema::create('keberangkatans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_keberangkatan')->unique();
            $table->foreignId('paket_id')->constrained('pakets')->onDelete('restrict');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_pulang');
            $table->string('bandara_keberangkatan')->default('CGK'); // kode bandara
            $table->string('no_penerbangan_pergi')->nullable();
            $table->string('no_penerbangan_pulang')->nullable();
            $table->integer('kuota'); // total seat tersedia
            $table->integer('terisi')->default(0); // sudah terisi
            $table->decimal('harga_double', 15, 2);
            $table->decimal('harga_triple', 15, 2);
            $table->decimal('harga_quad', 15, 2);
            $table->foreignId('pembimbing_id')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->enum('status', ['open', 'closed', 'berangkat', 'selesai', 'batal'])->default('open');
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
        Schema::dropIfExists('keberangkatans');
    }
};
