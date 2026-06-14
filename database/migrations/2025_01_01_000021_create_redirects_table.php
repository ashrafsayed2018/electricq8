<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('old_url')->unique();  // /ac-repair/salmia (old misspelled slug)
            $table->string('new_url');             // /ac-repair/salmiya
            $table->unsignedSmallInteger('status_code')->default(301); // 301 | 302
            $table->timestamps();

            $table->index('new_url');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redirects');
    }
};
