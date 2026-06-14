<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name', 100);
            $table->string('page_type', 100);
            $table->string('route_name', 150)->nullable();
            $table->string('locale', 10);
            $table->string('device_type', 20);
            $table->string('visitor_id', 100);
            $table->string('session_id', 100);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('url');
            $table->string('path', 2048);
            $table->text('referrer')->nullable();
            $table->string('placement', 100)->nullable();
            $table->string('channel', 50)->nullable();
            $table->text('cta_target')->nullable();
            $table->unsignedInteger('message_length')->nullable();
            $table->string('utm_source', 255)->nullable();
            $table->string('utm_medium', 255)->nullable();
            $table->string('utm_campaign', 255)->nullable();
            $table->string('utm_term', 255)->nullable();
            $table->string('utm_content', 255)->nullable();
            $table->json('metadata')->nullable();
            $table->string('country', 100)->nullable();
            $table->timestamps();

            // Base single-column indexes
            $table->index(['event_name', 'created_at']);
            $table->index(['page_type', 'created_at']);
            $table->index(['locale', 'created_at']);
            $table->index(['visitor_id', 'created_at']);
            $table->index('country');

            // Covering index for conversion filter combinations
            // (event_name + date range + device/locale/country)
            $table->index(
                ['event_name', 'created_at', 'device_type', 'locale', 'country'],
                'ae_conv_filter_idx'
            );

            // Covering index for the assisted-content self-JOIN (content side)
            $table->index(
                ['visitor_id', 'session_id', 'event_name', 'created_at'],
                'ae_visitor_session_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
    }
};
