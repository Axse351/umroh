<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  // database/migrations/xxxx_add_jamaah_id_to_users_table.php

public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('jamaah_id')->nullable()->constrained('jamaah')->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeignIdFor(\App\Models\Jamaah::class);
    });
}
};
