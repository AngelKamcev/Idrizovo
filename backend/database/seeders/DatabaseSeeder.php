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
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            ActivitiesSeeder::class,
            AnnouncementsSeeder::class,
            GalleryImageSeeder::class,
            ComplaintSeeder::class,
            InmateSeeder::class,
            TimeSlotSeeder::class,
            VisitScheduleSeeder::class,
            VisitRequestSeeder::class,
            VisitCompanionSeeder::class,
            // \Database\Seeders\SqlDumpSeeder::class,
        ]);
    }
}
