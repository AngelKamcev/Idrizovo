<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('translation_key', 150)->unique();
            $table->text('mk_text');
            $table->text('al_text');
            $table->text('en_text');
        });

        Schema::create('ui_language_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('selected_language', 10);
            $table->timestamp('timestamp')->useCurrent();
        });

        DB::statement("ALTER TABLE ui_language_logs ADD CONSTRAINT valid_selected_language CHECK (selected_language IN ('mk', 'al', 'en'))");

        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('event_type', 100);
            $table->string('ip_address', 64)->nullable();
            $table->text('device_info')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('data_change_history', function (Blueprint $table) {
            $table->id();
            $table->string('table_name', 100);
            $table->unsignedBigInteger('row_id');
            $table->foreignId('changed_by')->nullable()->constrained('users');
            $table->jsonb('old_data')->nullable();
            $table->jsonb('new_data')->nullable();
            $table->text('reason')->nullable();
            $table->timestamp('changed_at')->useCurrent();
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key', 100)->unique();
            $table->text('value');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('data_change_history');
        Schema::dropIfExists('security_logs');
        Schema::dropIfExists('ui_language_logs');
        Schema::dropIfExists('translations');
    }
};
