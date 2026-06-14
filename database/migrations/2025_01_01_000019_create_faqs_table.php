<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->json('question');            // {"ar":"كم تكلفة إصلاح الكهرباء؟","en":"How much does electrical repair cost?"}
            $table->json('answer');
            // repair | cleaning | installation | spare_parts | general
            $table->string('category')->default('general');
            $table->string('status')->default('active');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
