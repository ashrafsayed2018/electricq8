<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_keywords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keyword_id')->constrained()->cascadeOnDelete();
            // pillar | cluster | service | service_location_page
            $table->string('page_type');
            $table->unsignedBigInteger('page_id');
            // Enforces: one primary keyword belongs to exactly one page
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['page_type', 'page_id']);
            // A keyword can only be primary on one page
            $table->unique(['keyword_id', 'is_primary'], 'unique_primary_keyword');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_keywords');
    }
};
