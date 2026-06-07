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
        'image_path',
        'published_at',
        'is_active',
        'sort_order',
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
     * Get published announcements (just active ones)
     */
    public function scopePublished($query)
    {
        return $query; // All active announcements are published
    }

    /**
     * Get sorted announcements (by sort_order then newest first)
     */
    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderByDesc('created_at')->orderByDesc('id');
    }

    /**
     * Get image URL for announcement
     */
    public function getImageUrl()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return $this->image_url; // Fallback to old image_url column
    }
}
