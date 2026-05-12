<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create new activities table with JSON columns for translations
        Schema::create('main_activities', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Translatable: {mk: '', en: '', sq: ''}
            $table->json('description'); // Translatable: {mk: '', en: '', sq: ''}
            $table->text('content')->nullable();
            $table->string('icon')->nullable();
            $table->text('image_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index('sort_order');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('main_activities');
    }
};
