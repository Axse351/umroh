<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_hotels_table.php
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('kode_hotel')->unique();
            $table->string('nama_hotel');
            $table->enum('lokasi', ['mekkah', 'madinah', 'jeddah']); // lokasi di Arab Saudi
            $table->integer('bintang')->default(3); // 1-5
            $table->decimal('jarak_ke_masjid_meter', 8, 2)->nullable(); // jarak ke Masjidil Haram / Nabawi
            $table->string('no_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->text('fasilitas')->nullable();
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
        Schema::dropIfExists('hotels');
    }
};
