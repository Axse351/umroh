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
        Schema::create('welcome_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge');
            $table->string('title');                  // bisa ada HTML <span>
            $table->text('description');
            $table->string('btn_primary_text')->nullable();
            $table->string('btn_secondary_text')->nullable();
            $table->json('stats')->nullable();         // [{"num":"15+","label":"Tahun"}, ...]
            $table->string('image')->nullable();       // path file
            $table->string('overlay_color')->default('rgba(7,45,27,0.87)');
            $table->string('bg_color')->default('#1a4a2e');
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
        Schema::dropIfExists('welcome_slides');
    }
};
