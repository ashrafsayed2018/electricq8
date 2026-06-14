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
        Schema::table('service_location_pages', function (Blueprint $table) {
            $table->json('slug')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('service_location_pages', function (Blueprint $table) {
            $table->json('slug')->nullable(false)->change();
        });
    }
};
