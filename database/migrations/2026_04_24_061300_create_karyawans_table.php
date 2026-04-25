<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_karyawans_table.php
    public function up()
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_karyawan')->unique();
            $table->string('nama_lengkap');
            $table->string('nik', 16)->unique();
            $table->string('jabatan'); // direktur, admin, marketing, dll
            $table->string('divisi')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->string('email')->unique()->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
