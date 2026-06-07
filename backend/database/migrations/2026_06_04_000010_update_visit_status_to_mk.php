<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing rows
        DB::table('visit_requests')->where('status', 'approved')->update(['status' => 'Одобрено']);

        // Try to drop old constraint and add a new one that accepts both values (backwards compatible)
        $driver = Schema::getConnection()->getDriverName();

        try {
            if ($driver === 'mysql') {
                // MySQL: DROP CHECK <name>
                DB::statement('ALTER TABLE visit_requests DROP CHECK valid_visit_status');
            } elseif ($driver === 'pgsql') {
                DB::statement('ALTER TABLE visit_requests DROP CONSTRAINT IF EXISTS valid_visit_status');
            } elseif ($driver === 'sqlite') {
                // SQLite ignores CHECK dropping; skip
            }
        } catch (\Throwable $e) {
            // ignore if constraint didn't exist or drop failed
        }

        // Add a lenient constraint that accepts either the old english value or the new macedonian label
        $allowed = [
            'approved',
            'Одобрено',
            'cancelled_by_visitor',
            'cancelled_by_admin',
            'completed',
            'no_show',
        ];

        $inList = implode("','", $allowed);

        try {
            DB::statement("ALTER TABLE visit_requests ADD CONSTRAINT valid_visit_status CHECK (status IN ('{$inList}'))");
        } catch (\Throwable $e) {
            // ignore if statement fails on some DB engines
        }
    }

    public function down(): void
    {
        // Revert: set Macedonian back to english for safety
        DB::table('visit_requests')->where('status', 'Одобрено')->update(['status' => 'approved']);

        // Restore original constraint (english only)
        $driver = Schema::getConnection()->getDriverName();

        try {
            if ($driver === 'mysql') {
                DB::statement('ALTER TABLE visit_requests DROP CHECK valid_visit_status');
            } elseif ($driver === 'pgsql') {
                DB::statement('ALTER TABLE visit_requests DROP CONSTRAINT IF EXISTS valid_visit_status');
            }
        } catch (\Throwable $e) {
        }

        try {
            DB::statement("ALTER TABLE visit_requests ADD CONSTRAINT valid_visit_status CHECK (status IN ('approved','cancelled_by_visitor','cancelled_by_admin','completed','no_show'))");
        } catch (\Throwable $e) {
        }
    }
};
