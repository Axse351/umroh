<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_stok_opnames_table.php
    public function up()
    {
        Schema::create('stok_opnames', function (Blueprint $table) {
            $table->id();
            $table->string('no_opname')->unique();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('restrict');
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->integer('stok_sistem'); // stok di sistem sebelum opname
            $table->integer('stok_fisik');  // stok hasil hitung fisik
            $table->integer('selisih');     // fisik - sistem
            $table->date('tanggal_opname');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_opnames');
    }
};
