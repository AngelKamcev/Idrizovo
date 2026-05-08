<?php

namespace Database\Seeders;

use App\Models\VisitSchedule;
use Illuminate\Database\Seeder;

class VisitScheduleSeeder extends Seeder
{
    public function run(): void
    {
        VisitSchedule::updateOrCreate(
            ['group_name' => '1 Група'],
            ['days_label' => 'Понеделник - Четврток', 'time_range' => '08:30-09:30', 'sort_order' => 1, 'is_active' => true]
        );

        VisitSchedule::updateOrCreate(
            ['group_name' => '2 Група'],
            ['days_label' => 'Понеделник - Петок', 'time_range' => '10:30-11:30', 'sort_order' => 2, 'is_active' => true]
        );

        VisitSchedule::updateOrCreate(
            ['group_name' => '3 Група'],
            ['days_label' => 'Сабота и недела', 'time_range' => '12:30-13:30', 'sort_order' => 3, 'is_active' => true]
        );
    }
}
