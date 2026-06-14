<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('sort_order');
        });

        Schema::table('clusters', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });

        Schema::table('clusters', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
};
