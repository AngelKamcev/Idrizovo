<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Activity extends Model
{
    use HasTranslations;

    protected $table = 'main_activities';

    protected $fillable = [
        'title',
        'description',
        'content',
        'icon',
        'image_path',
        'sort_order',
        'is_active',
    ];

    /**
     * The translatable attributes
     */
    public array $translatable = ['title', 'description'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get only active activities
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get activities sorted by order
     */
    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order', 'asc')
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }

    /**
     * Get the image URL from the image path
     */
    public function getImageUrl()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return null;
    }
}
