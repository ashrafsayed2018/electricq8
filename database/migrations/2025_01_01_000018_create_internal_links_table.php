<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internal_links', function (Blueprint $table) {
            $table->id();
            // Source page (the page that contains the link)
            $table->string('source_type');       // pillar | cluster | service | service_location_page
            $table->unsignedBigInteger('source_id');
            // Target page (the page being linked to)
            $table->string('target_type');
            $table->unsignedBigInteger('target_id');
            $table->json('anchor_text');         // {"ar":"إصلاح الضاغط","en":"AC Compressor Repair"}
            $table->timestamps();

            $table->index(['source_type', 'source_id']);
            $table->index(['target_type', 'target_id']);
            // No duplicate links between the same pair
            $table->unique(['source_type', 'source_id', 'target_type', 'target_id'], 'unique_link_pair');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internal_links');
    }
};
