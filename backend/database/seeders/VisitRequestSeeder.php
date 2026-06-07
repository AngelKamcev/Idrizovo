<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisitRequest;
use App\Models\Inmate;
use App\Models\VisitSchedule;
use Illuminate\Support\Carbon;

class VisitRequestSeeder extends Seeder
{
    public function run()
    {
        $schedule = VisitSchedule::where('is_active', true)->first();
        $inmate = Inmate::first();

        if ($schedule && $inmate) {
            VisitRequest::firstOrCreate([
                'visitor_first_name' => 'Посетител',
                'visitor_last_name' => 'Тест',
                'requested_inmate_number' => $inmate->inmate_number,
            ], [
                'visitor_email' => null,
                'visitor_phone' => null,
                'visitor_relation_type' => 'family',
                'inmate_id' => $inmate->id,
                'visit_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'visit_schedule_id' => $schedule->id,
                'status' => 'approved',
            ]);
        }
    }
}
