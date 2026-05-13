<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisitRequest;
use App\Models\Inmate;
use App\Models\TimeSlot;
use Illuminate\Support\Carbon;

class VisitRequestSeeder extends Seeder
{
    public function run()
    {
        $inmate = Inmate::first();
        $visitDate = Carbon::now()->addDays(5);

        $timeSlot = TimeSlot::where('date', $visitDate->format('Y-m-d'))
            ->where('is_active', true)
            ->first();

        if ($inmate && $timeSlot) {
            VisitRequest::firstOrCreate([
                'visitor_first_name' => 'Посетител',
                'visitor_last_name' => 'Тест',
                'requested_inmate_number' => $inmate->inmate_number,
            ], [
                'visitor_email' => null,
                'visitor_phone' => null,
                'visitor_relation_type' => 'family',
                'inmate_id' => $inmate->id,
                'visit_date' => $visitDate->format('Y-m-d'),
                'time_slot_id' => $timeSlot->id,
                'status' => 'approved',
                'cancel_deadline' => $visitDate->copy()->subHours(48),
            ]);
        }
    }
}