<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cluster_id')->nullable()->constrained()->nullOnDelete();
            $table->json('title');               // {"ar":"إصلاح كهرباء سبليت","en":"Split Electrical Repair"}
            $table->json('slug');                // {"ar":"اصلاح-كهرباء-سبليت","en":"split-ac-repair"}
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->json('h1');
            $table->json('intro')->nullable();
            $table->json('content')->nullable();  // rich HTML per locale
            $table->json('canonical_url')->nullable();
            // split | central | window | cassette | portable | duct | general
            $table->string('service_type')->default('general');
            $table->unsignedInteger('price_from')->nullable();
            $table->unsignedInteger('price_to')->nullable();
            $table->json('faq_schema')->nullable(); // raw FAQ JSON-LD per locale
            $table->string('status')->default('active');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
