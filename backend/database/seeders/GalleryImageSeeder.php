<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryImage;

class GalleryImageSeeder extends Seeder
{
    public function run()
    {
        $images = [
            'gallery/img1.jpg',
            'gallery/img2.jpg',
            'gallery/img3.jpg',
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
