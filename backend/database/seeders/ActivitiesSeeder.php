<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitiesSeeder extends Seeder
{
    public function run()
    {
        $samples = [
            ['mk' => 'Шах', 'desc' => 'Тренинзи по шах за затвореници.'],
            ['mk' => 'Златарство', 'desc' => 'Работилница за златарство и метал.'],
            ['mk' => 'Бескрајно везење', 'desc' => 'Ембројдерска секција.'],
        ];

        foreach ($samples as $i => $s) {
            $a = Activity::firstOrNew(['sort_order' => $i + 1]);
            $a->setTranslation('title', 'mk', $s['mk']);
            $a->setTranslation('description', 'mk', $s['desc']);
            $a->image_path = 'activities/sample' . ($i + 1) . '.jpg';
            $a->is_active = true;
            $a->save();
        }
    }
}
