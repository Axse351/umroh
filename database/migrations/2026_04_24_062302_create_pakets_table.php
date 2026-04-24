<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_pakets_table.php
    public function up()
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_paket')->unique();
            $table->string('nama_paket');
            $table->enum('jenis', ['umroh', 'haji', 'haji_plus', 'haji_furoda']);
            $table->enum('kategori', ['regular', 'plus', 'vip', 'furoda'])->default('regular');
            $table->integer('durasi_hari');
            $table->foreignId('maskapai_id')->constrained('maskapais')->onDelete('restrict');
            $table->foreignId('hotel_mekkah_id')->constrained('hotels')->onDelete('restrict');
            $table->foreignId('hotel_madinah_id')->constrained('hotels')->onDelete('restrict');
            $table->integer('kapasitas'); // max jamaah per paket
            $table->decimal('harga_double', 15, 2); // harga kamar double
            $table->decimal('harga_triple', 15, 2); // harga kamar triple
            $table->decimal('harga_quad', 15, 2);   // harga kamar quad
            $table->text('include')->nullable();     // fasilitas yang termasuk
            $table->text('exclude')->nullable();     // yang tidak termasuk
            $table->text('itinerary')->nullable();
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
        Schema::dropIfExists('pakets');
    }
};
