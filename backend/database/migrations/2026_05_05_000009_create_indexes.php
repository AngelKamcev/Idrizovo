<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visit_requests', function (Blueprint $table) {
            $table->index(['inmate_id', 'visit_date'], 'idx_visit_requests_inmate_date');
            $table->index('time_slot_id', 'idx_visit_requests_time_slot');
            $table->index('status', 'idx_visit_requests_status');
        });

        Schema::table('time_slots', function (Blueprint $table) {
            $table->index('date', 'idx_time_slots_date');
        });

        Schema::table('complaints', function (Blueprint $table) {
            $table->index('status', 'idx_complaints_status');
        });

        Schema::table('news_posts', function (Blueprint $table) {
            $table->index(['is_published', 'published_at'], 'idx_news_posts_published');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->index(['is_published', 'published_at'], 'idx_activities_published');
        });

        Schema::table('gallery', function (Blueprint $table) {
            $table->index('category_id', 'idx_gallery_category');
        });
    }

    public function down(): void
    {
        Schema::table('gallery', function (Blueprint $table) {
            $table->dropIndex('idx_gallery_category');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropIndex('idx_activities_published');
        });

        Schema::table('news_posts', function (Blueprint $table) {
            $table->dropIndex('idx_news_posts_published');
        });

        Schema::table('complaints', function (Blueprint $table) {
            $table->dropIndex('idx_complaints_status');
        });

        Schema::table('time_slots', function (Blueprint $table) {
            $table->dropIndex('idx_time_slots_date');
        });

        Schema::table('visit_requests', function (Blueprint $table) {
            $table->dropIndex('idx_visit_requests_status');
            $table->dropIndex('idx_visit_requests_time_slot');
            $table->dropIndex('idx_visit_requests_inmate_date');
        });
    }
};
