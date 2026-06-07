<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisitCompanion;
use App\Models\VisitRequest;

class VisitCompanionSeeder extends Seeder
{
    public function run()
    {
        $request = VisitRequest::first();
        if ($request) {
            VisitCompanion::firstOrCreate([
                'visit_id' => $request->id,
                'first_name' => 'Спас',
                'last_name' => 'Сојуз',
            ], [
                'relation_to_visitor' => 'friend',
                'is_child' => false,
            ]);
        }
    }
}
