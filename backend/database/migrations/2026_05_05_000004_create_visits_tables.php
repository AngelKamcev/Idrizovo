<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_requests', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_first_name', 100);
            $table->string('visitor_last_name', 100);
            $table->string('visitor_email', 150)->nullable();
            $table->string('visitor_phone', 50)->nullable();
            $table->string('visitor_relation_type', 50);
            $table->foreignId('inmate_id')->constrained('inmates');
            $table->string('requested_inmate_number', 50);
            $table->date('visit_date');
            $table->foreignId('time_slot_id')->constrained('time_slots');
            $table->string('status', 50)->default('approved');
            $table->timestamp('cancel_deadline');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        DB::statement("ALTER TABLE visit_requests ADD CONSTRAINT valid_relation_type CHECK (visitor_relation_type IN ('family', 'friend', 'other'))");
        DB::statement("ALTER TABLE visit_requests ADD CONSTRAINT valid_visit_status CHECK (status IN ('approved', 'cancelled_by_visitor', 'cancelled_by_admin', 'completed', 'no_show'))");

        Schema::create('visit_companions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visit_requests')->cascadeOnDelete();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('relation_to_visitor', 50);
            $table->boolean('is_child')->default(false);
        });

        Schema::create('visit_confirmations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->unique()->constrained('visit_requests')->cascadeOnDelete();
            $table->string('confirmation_code', 100)->unique();
            $table->string('qr_code_token', 150)->unique();
            $table->text('pdf_url')->nullable();
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamp('valid_until');
        });

        Schema::create('visit_cancellations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visit_requests');
            $table->string('cancelled_by_type', 50);
            $table->foreignId('cancelled_by_user_id')->nullable()->constrained('users');
            $table->text('reason');
            $table->timestamp('cancelled_at')->useCurrent();
        });

        DB::statement("ALTER TABLE visit_cancellations ADD CONSTRAINT valid_cancelled_by_type CHECK (cancelled_by_type IN ('visitor', 'admin'))");

        Schema::create('visit_modifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visit_requests');
            $table->foreignId('changed_by_admin')->constrained('users');
            $table->date('old_visit_date')->nullable();
            $table->date('new_visit_date')->nullable();
            $table->foreignId('old_time_slot_id')->nullable()->constrained('time_slots');
            $table->foreignId('new_time_slot_id')->nullable()->constrained('time_slots');
            $table->foreignId('old_inmate_id')->nullable()->constrained('inmates');
            $table->foreignId('new_inmate_id')->nullable()->constrained('inmates');
            $table->string('old_requested_inmate_number', 50)->nullable();
            $table->string('new_requested_inmate_number', 50)->nullable();
            $table->text('reason');
            $table->timestamp('changed_at')->useCurrent();
        });

        Schema::create('visit_checkin_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visit_requests');
            $table->timestamp('checked_in_at')->useCurrent();
            $table->timestamp('checked_out_at')->nullable();
            $table->foreignId('verified_by_staff')->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_checkin_logs');
        Schema::dropIfExists('visit_modifications');
        Schema::dropIfExists('visit_cancellations');
        Schema::dropIfExists('visit_confirmations');
        Schema::dropIfExists('visit_companions');
        Schema::dropIfExists('visit_requests');
    }
};
