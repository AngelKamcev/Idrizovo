<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compliments', function (Blueprint $table) {
            $table->id();
            $table->string('submitted_by_name', 150);
            $table->string('submitted_by_email', 150)->nullable();
            $table->string('submitted_by_phone', 50)->nullable();
            $table->string('subject', 200);
            $table->text('message');
            $table->string('status', 50)->default('new');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('compliment_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compliment_id')->constrained('compliments')->cascadeOnDelete();
            $table->foreignId('responded_by')->constrained('users');
            $table->text('message');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compliment_responses');
        Schema::dropIfExists('compliments');
    }
};
