<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_agents_table.php
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('kode_agent')->unique();
            $table->string('nama_agent');
            $table->string('nama_pic'); // person in charge
            $table->enum('jenis', ['umroh', 'haji', 'keduanya'])->default('keduanya');
            $table->string('no_telepon', 20);
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->decimal('komisi_persen', 5, 2)->default(0); // % komisi per transaksi
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
        Schema::dropIfExists('agents');
    }
};
