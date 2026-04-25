<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_tabungans_table.php
    public function up()
    {
        Schema::create('tabungans', function (Blueprint $table) {
            $table->id();
            $table->string('no_rekening_tabungan')->unique();
            $table->foreignId('jamaah_id')->constrained('jamaah')->onDelete('restrict');
            $table->enum('jenis', ['umroh', 'haji']);
            $table->decimal('target_tabungan', 15, 2); // target nominal
            $table->decimal('saldo', 15, 2)->default(0);
            $table->date('tanggal_buka');
            $table->date('tanggal_target')->nullable(); // target lunas
            $table->enum('status', ['aktif', 'selesai', 'batal'])->default('aktif');
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
        Schema::dropIfExists('tabungans');
    }
};
