<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimeSlot;
use Illuminate\Support\Carbon;

class TimeSlotSeeder extends Seeder
{
    public function run()
    {
        $dates = [
            Carbon::now()->addDays(3)->format('Y-m-d'),
            Carbon::now()->addDays(7)->format('Y-m-d'),
        ];

        foreach ($dates as $d) {
            TimeSlot::firstOrCreate([
                'date' => $d,
                'start_time' => '09:00',
                'end_time' => '11:00',
            ], [
                'capacity_total' => 15,
                'capacity_used' => 0,
                'is_active' => true,
            ]);
        }
    }
}
