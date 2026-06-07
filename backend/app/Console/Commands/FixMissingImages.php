<?php

namespace App\Console\Commands;

use App\Helpers\ImageUrl;
use App\Models\GalleryImage;
use App\Models\SystemSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FixMissingImages extends Command
{
    protected $signature = 'cms:fix-missing-images';

    protected $description = 'Remove broken image references and restore working gallery/izrabotki placeholders';

    public function handle(): int
    {
        $removedGallery = 0;

        GalleryImage::query()->each(function (GalleryImage $image) use (&$removedGallery) {
            if (! ImageUrl::localFileMissing((string) $image->image_path)) {
                return;
            }

            $image->delete();
            $removedGallery++;
        });

        $seededGallery = 0;

        if (GalleryImage::active()->count() < 4) {
            $needed = 4 - GalleryImage::active()->count();
            $startOrder = (int) (GalleryImage::max('sort_order') ?? 0);

            for ($i = 0; $i < $needed; $i++) {
                $image = new GalleryImage([
                    'album' => 'Галерија',
                    'description' => 'Галерија '.($i + 1),
                    'image_path' => ImageUrl::galleryPlaceholder($i + 1),
                    'sort_order' => $startOrder + $i + 1,
                    'is_active' => true,
                ]);

                foreach (['mk', 'en', 'sq'] as $locale) {
                    $image->setTranslation('title', $locale, 'Галерија '.($i + 1));
                }

                $image->save();
                $seededGallery++;
            }
        }

        $izrabotkiReset = false;

        if (SystemSetting::where('setting_key', 'izrabotki_page')->exists()) {
            SystemSetting::where('setting_key', 'izrabotki_page')->delete();
            $izrabotkiReset = true;
        }

        foreach (['mk', 'en', 'sq'] as $locale) {
            Cache::forget('izrabotki_page_data_'.$locale);
        }
        Cache::forget('gallery_page_all');
        Cache::forget('home_gallery');

        $this->info("Removed {$removedGallery} gallery record(s) with missing files.");
        $this->info("Seeded {$seededGallery} placeholder gallery image(s).");

        if ($izrabotkiReset) {
            $this->info('Reset izrabotki page to default placeholder images.');
        } else {
            $this->info('Izrabotki page was already using defaults.');
        }

        $this->info('Image caches cleared.');

        return self::SUCCESS;
    }
}
