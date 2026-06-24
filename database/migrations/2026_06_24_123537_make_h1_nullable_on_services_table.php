<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->json('h1')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->json('h1')->nullable(false)->change();
        });
    }
};
