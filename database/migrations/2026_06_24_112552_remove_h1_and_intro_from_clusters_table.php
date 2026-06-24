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
        Schema::table('clusters', function (Blueprint $table) {
            $table->dropColumn(['h1', 'intro']);
        });
    }

    public function down(): void
    {
        Schema::table('clusters', function (Blueprint $table) {
            $table->json('h1')->nullable()->after('slug');
            $table->json('intro')->nullable()->after('h1');
        });
    }
};
