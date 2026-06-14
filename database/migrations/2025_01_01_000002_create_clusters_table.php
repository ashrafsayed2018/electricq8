<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clusters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pillar_id')->constrained()->cascadeOnDelete();
            $table->json('title');               // {"ar":"إصلاح الكهرباء","en":"Electrical Repair"}
            $table->json('slug');                // {"ar":"اصلاح-كهرباء","en":"ac-repair"}
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->json('h1');
            $table->json('intro')->nullable();
            $table->json('content')->nullable();
            $table->json('canonical_url')->nullable();
            // informational | commercial | transactional | navigational
            $table->string('search_intent')->default('commercial');
            $table->string('status')->default('active');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clusters');
    }
};
