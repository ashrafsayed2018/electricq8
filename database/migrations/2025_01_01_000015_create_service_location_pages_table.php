<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_location_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();

            // Every column unique to this service+location combo
            $table->json('title');               // {"ar":"إصلاح كهرباء السالمية","en":"Electrical Repair in Salmiya"}
            $table->json('slug');                // {"ar":"اصلاح-كهرباء-السالمية","en":"ac-repair-salmiya"}
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->json('h1');
            $table->json('intro')->nullable();                  // unique local angle intro
            $table->json('unique_local_content')->nullable();   // body content specific to this location
            $table->json('local_problem')->nullable();          // "In Salmiya, humidity causes..."
            $table->json('local_solution')->nullable();         // "Our team in Salmiya..."
            $table->json('cta_text')->nullable();
            $table->json('canonical_url')->nullable();
            $table->boolean('noindex')->default(false);         // thin content protection
            $table->string('status')->default('active');
            $table->timestamps();

            // One page per service+location combo
            $table->unique(['service_id', 'location_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_location_pages');
    }
};
