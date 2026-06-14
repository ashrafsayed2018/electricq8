<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->json('keyword');             // {"ar":"إصلاح كهرباء","en":"ac repair"}
            // informational | commercial | transactional | navigational
            $table->string('intent')->default('commercial');
            // pillar | cluster | service | location | blog
            $table->string('type')->default('service');
            $table->unsignedInteger('search_volume')->nullable();
            $table->unsignedTinyInteger('difficulty')->nullable(); // 0-100
            // active | paused | cannibalized
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keywords');
    }
};
