<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('gallery_images')) {
            return;
        }

        Schema::table('gallery_images', function (Blueprint $table) {
            if (! Schema::hasColumn('gallery_images', 'album')) {
                $table->string('album', 150)->nullable()->after('title');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('gallery_images')) {
            return;
        }

        Schema::table('gallery_images', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_images', 'album')) {
                $table->dropColumn('album');
            }
        });
    }
};
