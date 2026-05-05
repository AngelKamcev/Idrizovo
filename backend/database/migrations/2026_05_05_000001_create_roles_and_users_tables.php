<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 150)->unique();
            $table->text('password_hash');
            $table->string('phone', 50)->nullable();
            $table->foreignId('role_id')->constrained('roles');
            $table->string('language_preference', 10)->default('mk');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('last_login')->nullable();
            $table->boolean('is_active')->default(true);
        });

        DB::statement("ALTER TABLE users ADD CONSTRAINT valid_user_language CHECK (language_preference IN ('mk', 'al', 'en'))");

        Schema::create('auth_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('token');
            $table->timestamp('expires_at');
            $table->string('ip_address', 64)->nullable();
            $table->text('device_info')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('admin_auth_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users');
            $table->string('action', 50);
            $table->string('ip_address', 64)->nullable();
            $table->timestamp('timestamp')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_auth_logs');
        Schema::dropIfExists('auth_sessions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
