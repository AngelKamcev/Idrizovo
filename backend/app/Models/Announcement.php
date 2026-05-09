<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Announcement extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'content',
        'image_url',
        'published_at',
        'is_active',
    ];

    /**
     * The translatable attributes
     */
    public array $translatable = ['title', 'content'];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get only active announcements
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get published announcements (published_at is set)
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
