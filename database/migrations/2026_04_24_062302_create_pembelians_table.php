<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_pembelians_table.php
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('no_pembelian')->unique();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('restrict');
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->date('tanggal_beli');
            $table->decimal('total', 15, 2)->default(0);
            $table->enum('status', ['pending', 'diterima', 'sebagian', 'batal'])->default('pending');
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
        Schema::dropIfExists('pembelians');
    }
};
