<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('handcraft_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title_mk', 200);
            $table->string('title_al', 200)->nullable();
            $table->string('title_en', 200)->nullable();
            $table->text('description_mk');
            $table->text('description_al')->nullable();
            $table->text('description_en')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('handcrafts', function (Blueprint $table) {
            $table->foreignId('group_id')
                ->nullable()
                ->after('id')
                ->constrained('handcraft_groups')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('handcrafts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('group_id');
        });

        Schema::dropIfExists('handcraft_groups');
    }
};
