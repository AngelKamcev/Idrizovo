<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Performance indexes for the most frequently queried columns.
 * Run: php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        // announcements: is_active + sort_order + created_at (active/published/sorted scope)
        Schema::table('announcements', function (Blueprint $table) {
            if (!$this->indexExists('announcements', 'announcements_active_sorted_idx')) {
                $table->index(['is_active', 'sort_order', 'created_at'], 'announcements_active_sorted_idx');
            }
        });

        // main_activities: is_active + sort_order
        Schema::table('main_activities', function (Blueprint $table) {
            if (!$this->indexExists('main_activities', 'activities_active_sorted_idx')) {
                $table->index(['is_active', 'sort_order', 'created_at'], 'activities_active_sorted_idx');
            }
        });

        // gallery_images: is_active + sort_order
        Schema::table('gallery_images', function (Blueprint $table) {
            if (!$this->indexExists('gallery_images', 'gallery_active_sorted_idx')) {
                $table->index(['is_active', 'sort_order'], 'gallery_active_sorted_idx');
            }
        });

        // system_settings: setting_key lookup (used for about/izrabotki pages)
        Schema::table('system_settings', function (Blueprint $table) {
            if (!$this->indexExists('system_settings', 'system_settings_key_idx')) {
                $table->index('setting_key', 'system_settings_key_idx');
            }
        });

        // visit_schedules: is_active
        Schema::table('visit_schedules', function (Blueprint $table) {
            if (!$this->indexExists('visit_schedules', 'visit_schedules_active_idx')) {
                $table->index(['is_active', 'sort_order'], 'visit_schedules_active_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('announcements', fn(Blueprint $t) => $t->dropIndex('announcements_active_sorted_idx'));
        Schema::table('main_activities', fn(Blueprint $t) => $t->dropIndex('activities_active_sorted_idx'));
        Schema::table('gallery_images', fn(Blueprint $t) => $t->dropIndex('gallery_active_sorted_idx'));
        Schema::table('system_settings', fn(Blueprint $t) => $t->dropIndex('system_settings_key_idx'));
        Schema::table('visit_schedules', fn(Blueprint $t) => $t->dropIndex('visit_schedules_active_idx'));
    }

    private function indexExists(string $table, string $indexName): bool
    {
        return collect(\DB::select("SHOW INDEX FROM `{$table}`"))
            ->pluck('Key_name')
            ->contains($indexName);
    }
};
