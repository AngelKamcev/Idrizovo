<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $reviewerRole = Role::firstOrCreate(['name' => 'reviewer']);
        $vospituvacRole = Role::firstOrCreate(['name' => 'vospituvac']);

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'password_hash' => Hash::make('Password123!'),
                'role_id' => $adminRole->id,
                'language_preference' => 'mk',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'mail-admin@example.com'],
            [
                'first_name' => 'Mail Admin',
                'last_name' => 'User',
                'password_hash' => Hash::make('Password123!'),
                'role_id' => $adminRole->id,
                'language_preference' => 'mk',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'reviewer@example.com'],
            [
                'first_name' => 'Reviewer',
                'last_name' => 'User',
                'password_hash' => Hash::make('Password123!'),
                'role_id' => $reviewerRole->id,
                'language_preference' => 'mk',
                'is_active' => true,
            ]
        );

        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => "vospituvac{$i}@example.com"],
                [
                    'first_name' => "Vospituvac {$i}",
                    'last_name' => '',
                    'password_hash' => Hash::make('Password123!'),
                    'role_id' => $vospituvacRole->id,
                    'language_preference' => 'mk',
                    'is_active' => true,
                ]
            );
        }
    }
}
