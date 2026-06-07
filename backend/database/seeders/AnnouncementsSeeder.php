<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Illuminate\Support\Carbon;

class AnnouncementsSeeder extends Seeder
{
    public function run()
    {
        $samples = [
            ['title' => 'Советување за семејствa', 'content' => 'Имате можност за советување секој вторник.'],
            ['title' => 'Нова работилница', 'content' => 'Започнува работилница за столарија.'],
        ];

        foreach ($samples as $i => $s) {
            $ann = Announcement::firstOrNew(['sort_order' => $i + 1]);
            $ann->setTranslation('title', 'mk', $s['title']);
            $ann->setTranslation('content', 'mk', $s['content']);
            $ann->image_path = 'announcements/sample' . ($i + 1) . '.jpg';
            $ann->published_at = Carbon::now()->subDays($i);
            $ann->is_active = true;
            $ann->save();
        }
    }
}
