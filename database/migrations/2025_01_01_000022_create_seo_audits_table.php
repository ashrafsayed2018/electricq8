<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_audits', function (Blueprint $table) {
            $table->id();
            // pillar | cluster | service | service_location_page
            $table->string('page_type');
            $table->unsignedBigInteger('page_id');
            $table->json('primary_keyword')->nullable();       // snapshot at audit time
            // MD5 hashes for fast duplicate detection
            $table->string('meta_title_hash', 32)->nullable();
            $table->string('meta_description_hash', 32)->nullable();
            $table->string('content_hash', 32)->nullable();
            // 0.00–1.00 cosine similarity vs duplicate candidate
            $table->decimal('similarity_score', 4, 2)->nullable();
            // Points to the page this one is a duplicate of (nullable = no duplicate found)
            $table->string('duplicate_of_page_type')->nullable();
            $table->unsignedBigInteger('duplicate_of_page_id')->nullable();
            $table->timestamp('audited_at');
            $table->timestamps();

            $table->index(['page_type', 'page_id']);
            $table->index(['duplicate_of_page_type', 'duplicate_of_page_id']);
            $table->index('meta_title_hash');
            $table->index('content_hash');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_audits');
    }
};
