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
            GalleryImage::firstOrCreate(
                ['image_url' => $path],
                [
                    'title' => 'Галерија ' . ($i + 1),
                    'sort_order' => $i + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}