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
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreignId('tabungan_id')
                ->nullable()
                ->after('karyawan_id')
                ->constrained('tabungans')
                ->nullOnDelete();

            // Catat berapa saldo tabungan yang ditarik untuk pembayaran ini
            $table->decimal('jumlah_dari_tabungan', 18, 2)
                ->default(0)
                ->after('tabungan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropForeign(['tabungan_id']);
            $table->dropColumn(['tabungan_id', 'jumlah_dari_tabungan']);
        });
    }
};
