<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_id')->constrained()->cascadeOnDelete();
            // pillar | cluster | service | service_location_page
            $table->string('page_type');
            $table->unsignedBigInteger('page_id');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['page_type', 'page_id']);
            // Same FAQ can only appear once per page
            $table->unique(['faq_id', 'page_type', 'page_id'], 'unique_faq_per_page');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_faqs');
    }
};
