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
        'image_url',
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
}
