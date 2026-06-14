<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->json('name');                // {"ar":"السالمية","en":"Salmiya"}
            $table->json('slug');                // {"ar":"سالمية","en":"salmiya"}
            // capital | hawalli | farwaniya | ahmadi | jahra | mubarak_al_kabeer
            $table->string('governorate')->default('hawalli');
            $table->json('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
