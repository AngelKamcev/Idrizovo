<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inmates', function (Blueprint $table) {
            $table->id();
            $table->string('inmate_number', 50)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('status', 50)->default('active');
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        DB::statement("ALTER TABLE inmates ADD CONSTRAINT valid_inmate_status CHECK (status IN ('active', 'inactive', 'released', 'transferred'))");

        Schema::create('inmate_number_changes_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inmate_id')->constrained('inmates');
            $table->string('old_number', 50);
            $table->string('new_number', 50);
            $table->foreignId('changed_by_admin')->constrained('users');
            $table->text('reason');
            $table->timestamp('changed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inmate_number_changes_log');
        Schema::dropIfExists('inmates');
    }
};
