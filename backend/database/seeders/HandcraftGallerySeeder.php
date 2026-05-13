<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HandcraftGallerySeeder extends Seeder
{
    public function run(): void
    {
        $adminId = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.name', 'admin')
            ->value('users.id') ?? 1;

        $categories = [
            'igla-konec'  => 'Уметност со игла и конец',
            'drvorez'     => 'Дрворез',
            'slikarstvo'  => 'Боја и перспектива: слики од работилницата',
            'grncharstvo' => 'Грнчарство',
        ];

        // Picsum IDs to use per category (6 images each, all different)
        $picsumIds = [
            'igla-konec'  => [10, 20, 30, 40, 50, 60],
            'drvorez'     => [70, 80, 90, 100, 110, 120],
            'slikarstvo'  => [130, 140, 150, 160, 170, 180],
            'grncharstvo' => [190, 200, 210, 220, 230, 240],
        ];

        $descriptions = [
            'igla-konec'  => 'Рачно изработено со игла и конец',
            'drvorez'     => 'Рачно резбана дрвена фигура',
            'slikarstvo'  => 'Акварелна слика од работилницата',
            'grncharstvo' => 'Рачно изработен грнчарски предмет',
        ];

        foreach ($categories as $slug => $labelMk) {
            // Upsert gallery_category row
            $catId = DB::table('gallery_categories')->where('name_mk', $labelMk)->value('id');
            if (!$catId) {
                $catId = DB::table('gallery_categories')->insertGetId([
                    'name_mk'   => $labelMk,
                    'name_en'   => $labelMk,
                    'name_al'   => $labelMk,
                    'is_active' => true,
                ]);
            }

            // Seed 6 sample images per category using picsum
            foreach ($picsumIds[$slug] as $picsumId) {
                $url = "https://picsum.photos/id/{$picsumId}/600/400";

                DB::table('gallery')->updateOrInsert(
                    ['image_url' => $url],
                    [
                        'description_mk'     => $descriptions[$slug] ?? null,
                        'description_en'     => null,
                        'description_al'     => null,
                        'category_id'        => $catId,
                        'handcraft_category' => $slug,
                        'uploaded_by'        => $adminId,
                        'is_published'       => true,
                        'created_at'         => now(),
                    ]
                );
            }
        }
    }
}
