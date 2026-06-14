<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pillars', function (Blueprint $table) {
            $table->id();
            $table->json('title');               // {"ar":"خدمات الكهرباء في الكويت","en":"Electrical Services in Kuwait"}
            $table->json('slug');                // {"ar":"خدمات-كهرباء-الكويت","en":"ac-services-kuwait"}
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->json('h1');
            $table->json('intro')->nullable();
            $table->json('content')->nullable();  // rich HTML per locale
            $table->json('canonical_url')->nullable();
            $table->string('status')->default('active'); // active | draft | archived
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pillars');
    }
};
