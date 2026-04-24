<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_maskapais_table.php
    public function up()
    {
        Schema::create('maskapais', function (Blueprint $table) {
            $table->id();
            $table->string('kode_maskapai')->unique();
            $table->string('nama_maskapai');
            $table->string('kode_iata', 5)->nullable(); // GA, SV, EK dll
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
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
        Schema::dropIfExists('maskapais');
    }
};
