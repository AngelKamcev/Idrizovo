<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inmate;

class InmateSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            Inmate::firstOrCreate([
                'inmate_number' => 'INM' . str_pad($i, 3, '0', STR_PAD_LEFT),
            ], [
                'first_name' => 'Име' . $i,
                'last_name' => 'Презиме' . $i,
                'status' => 'active',
            ]);
        }
    }
}
