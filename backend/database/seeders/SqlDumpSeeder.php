<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SqlDumpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Expect the SQL dump to be at workspace root next to the backend folder
        $path = base_path('../127_0_0_1 (1).sql');

        if (!file_exists($path)) {
            if ($this->command) {
                $this->command->warn("SQL dump not found at: {$path}. Skipping import.");
            }
            return;
        }

        $sql = file_get_contents($path);

        // Remove database creation and use statements so the dump imports into the current connection
        $sql = preg_replace('/^--.*$/m', '', $sql); // remove SQL comments
        $sql = preg_replace('/^\/\*!.*?\*\/;?/ms', '', $sql); // remove /*! ... */ blocks
        $sql = preg_replace('/CREATE DATABASE.*?;/mi', '', $sql);
        $sql = preg_replace('/USE `?[^;`]+`?;?/mi', '', $sql);
        $sql = str_replace("SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";", '', $sql);
        $sql = str_replace('START TRANSACTION;', '', $sql);
        $sql = str_replace('COMMIT;', '', $sql);

        // Execute the SQL. DB::unprepared can run multiple statements in the dump.
        DB::unprepared($sql);

        if ($this->command) {
            $this->command->info('SQL dump imported successfully (if there were no errors).');
        }
    }
}
