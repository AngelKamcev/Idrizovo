<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->date('date')->unique();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('visit_group_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('day_type', 50);
            $table->integer('default_capacity')->default(15);
            $table->boolean('is_active')->default(true);
        });

        DB::statement("ALTER TABLE visit_group_templates ADD CONSTRAINT valid_day_type CHECK (day_type IN ('weekday', 'weekend', 'holiday'))");
        DB::statement("ALTER TABLE visit_group_templates ADD CONSTRAINT valid_default_capacity CHECK (default_capacity > 0)");

        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('group_template_id')->nullable()->constrained('visit_group_templates');
            $table->integer('capacity_total')->default(15);
            $table->integer('capacity_used')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->unique(['date', 'start_time', 'end_time']);
        });

        DB::statement('ALTER TABLE time_slots ADD CONSTRAINT valid_time_slot CHECK (end_time > start_time)');
        DB::statement('ALTER TABLE time_slots ADD CONSTRAINT valid_capacity_total CHECK (capacity_total > 0)');
        DB::statement('ALTER TABLE time_slots ADD CONSTRAINT valid_capacity_used CHECK (capacity_used >= 0)');
        DB::statement('ALTER TABLE time_slots ADD CONSTRAINT capacity_used_not_over_total CHECK (capacity_used <= capacity_total)');

        Schema::create('time_slot_capacity_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('time_slot_id')->constrained('time_slots');
            $table->integer('old_capacity');
            $table->integer('new_capacity');
            $table->foreignId('changed_by_admin')->constrained('users');
            $table->text('reason');
            $table->timestamp('changed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_slot_capacity_history');
        Schema::dropIfExists('time_slots');
        Schema::dropIfExists('visit_group_templates');
        Schema::dropIfExists('holidays');
    }
};
