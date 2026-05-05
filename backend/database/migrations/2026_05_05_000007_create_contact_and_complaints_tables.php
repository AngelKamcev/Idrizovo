<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_info', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 50);
            $table->string('email', 150);
            $table->text('address_mk');
            $table->text('address_al')->nullable();
            $table->text('address_en')->nullable();
            $table->text('working_hours_mk')->nullable();
            $table->text('working_hours_al')->nullable();
            $table->text('working_hours_en')->nullable();
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('director_info', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->text('bio_mk')->nullable();
            $table->text('bio_al')->nullable();
            $table->text('bio_en')->nullable();
            $table->text('image_url')->nullable();
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('complaints', function (Blueprint $table) {
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

        DB::statement("ALTER TABLE complaints ADD CONSTRAINT valid_complaint_status CHECK (status IN ('new', 'seen', 'in_progress', 'closed'))");

        Schema::create('complaint_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained('complaints')->cascadeOnDelete();
            $table->foreignId('responded_by')->constrained('users');
            $table->text('message');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_responses');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('director_info');
        Schema::dropIfExists('contact_info');
    }
};
