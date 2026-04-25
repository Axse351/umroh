<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_jamaah_table.php
    public function up()
    {
        Schema::create('jamaah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jamaah')->unique();
            $table->string('nama_lengkap');
            $table->string('nama_arab')->nullable();
            $table->string('nik', 16)->unique();
            $table->string('no_passport')->unique()->nullable();
            $table->date('exp_passport')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('kode_pos', 10)->nullable();
            $table->string('no_telepon', 20);
            $table->string('email')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('nama_mahram')->nullable(); // wali/mahram untuk jamaah wanita
            $table->string('hubungan_mahram')->nullable();
            $table->string('golongan_darah', 5)->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->string('foto')->nullable();
            $table->string('foto_passport')->nullable();
            $table->string('foto_ktp')->nullable();
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
        Schema::dropIfExists('jamaahs');
    }
};
