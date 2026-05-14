<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class GalleryImage extends Model
{
    use HasTranslations;

    protected $table = 'gallery_images';

    protected $fillable = [
        'title',
        'album',
        'image_path',
        'thumbnail_url',
        'description',
        'sort_order',
        'is_active',
    ];

    /**
     * The translatable attributes
     */
    public array $translatable = ['title'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get only active gallery images
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get images sorted by order
     */
    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Title for current locale (fallback mk → en → sq).
     */
    public function displayTitle(): string
    {
        foreach ([app()->getLocale(), 'mk', 'en', 'sq'] as $locale) {
            $t = $this->getTranslation('title', $locale);

            if (is_string($t) && $t !== '') {
                return $t;
            }
        }

        return '';
    }

    /**
     * Public URL for the stored image (supports /storage/... or absolute URLs).
     */
    public function getResolvedUrlAttribute(): string
    {
        $u = (string) ($this->image_path ?? '');

        if ($u === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $u)) {
            return $u;
        }

        if (str_starts_with($u, '/storage/') || str_starts_with($u, 'storage/')) {
            return asset(ltrim($u, '/'));
        }

        return asset('storage/'.ltrim($u, '/'));
    }

    public function adminTitle(): string
    {
        foreach (['mk', 'en', 'sq'] as $locale) {
            $t = $this->getTranslation('title', $locale);

            if (is_string($t) && $t !== '') {
                return $t;
            }
        }

        return '';
    }
}
