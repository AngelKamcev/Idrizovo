<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title_mk', 200);
            $table->string('title_al', 200)->nullable();
            $table->string('title_en', 200)->nullable();
            $table->text('content_mk');
            $table->text('content_al')->nullable();
            $table->text('content_en')->nullable();
            $table->text('image_url')->nullable();
            $table->string('activity_type', 100);
            $table->boolean('is_published')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('published_at')->nullable();
        });

        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title_mk', 200);
            $table->string('title_al', 200)->nullable();
            $table->string('title_en', 200)->nullable();
            $table->text('content_mk');
            $table->text('content_al')->nullable();
            $table->text('content_en')->nullable();
            $table->boolean('pinned')->default(false);
            $table->boolean('is_published')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('published_at')->nullable();
        });

        Schema::create('handcrafts', function (Blueprint $table) {
            $table->id();
            $table->string('title_mk', 200);
            $table->string('title_al', 200)->nullable();
            $table->string('title_en', 200)->nullable();
            $table->text('description_mk');
            $table->text('description_al')->nullable();
            $table->text('description_en')->nullable();
            $table->text('image_url');
            $table->boolean('is_published')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('published_at')->nullable();
        });

        Schema::create('gallery_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_mk', 100);
            $table->string('name_al', 100)->nullable();
            $table->string('name_en', 100)->nullable();
            $table->boolean('is_active')->default(true);
        });

        Schema::create('gallery', function (Blueprint $table) {
            $table->id();
            $table->text('image_url');
            $table->text('description_mk')->nullable();
            $table->text('description_al')->nullable();
            $table->text('description_en')->nullable();
            $table->foreignId('category_id')->constrained('gallery_categories');
            $table->foreignId('uploaded_by')->constrained('users');
            $table->boolean('is_published')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('external_activities', function (Blueprint $table) {
            $table->id();
            $table->string('title_mk', 200);
            $table->string('title_al', 200)->nullable();
            $table->string('title_en', 200)->nullable();
            $table->text('description_mk');
            $table->text('description_al')->nullable();
            $table->text('description_en')->nullable();
            $table->date('activity_date');
            $table->text('image_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_activities');
        Schema::dropIfExists('gallery');
        Schema::dropIfExists('gallery_categories');
        Schema::dropIfExists('handcrafts');
        Schema::dropIfExists('news_posts');
        Schema::dropIfExists('activities');
    }
};
