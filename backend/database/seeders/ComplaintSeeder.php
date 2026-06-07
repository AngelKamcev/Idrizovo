<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Complaint;

class ComplaintSeeder extends Seeder
{
    public function run()
    {
        Complaint::firstOrCreate([
            'submitted_by_name' => 'Посетител 1',
            'subject' => 'Пофалба - Вработени',
        ], [
            'message' => 'Одлична поддршка од персоналот.',
            'status' => 'new',
        ]);
    }
}
