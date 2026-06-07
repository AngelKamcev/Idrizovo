<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryImage;

class GalleryImageSeeder extends Seeder
{
    public function run()
    {
        $images = [
            'https://picsum.photos/id/101/500/400',
            'https://picsum.photos/id/102/500/400',
            'https://picsum.photos/id/103/500/400',
            'https://picsum.photos/id/104/500/400',
        ];

        foreach ($images as $i => $path) {
            $img = GalleryImage::firstOrCreate(
                ['image_path' => $path],
                [
                    'album' => 'Галерија',
                    'description' => 'Галерија '.($i + 1),
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
            foreach (['mk', 'en', 'sq'] as $loc) {
                $img->setTranslation('title', $loc, 'Галерија '.($i + 1));
            }
            $img->save();
        }
    }
}
