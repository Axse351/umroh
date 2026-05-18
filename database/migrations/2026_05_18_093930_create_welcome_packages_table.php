<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('welcome_packages', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->default('umroh'); // umroh | haji
            $table->string('name');
            $table->string('badge')->nullable();       // "Paling Diminati", "Tanpa Antri", dll
            $table->boolean('is_featured')->default(false);
            $table->string('price');                   // "Rp 25.000.000"
            $table->string('duration');                // "10 Hari 9 Malam"
            $table->string('hotel');                   // "Hotel Bintang 3"
            $table->json('features');                  // ["Tiket PP + Visa", ...]
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcome_packages');
    }
};
