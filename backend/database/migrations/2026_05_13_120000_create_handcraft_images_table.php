<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('handcraft_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handcraft_id')->constrained('handcrafts')->cascadeOnDelete();
            $table->string('image_url', 1024);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handcraft_images');
    }
};
