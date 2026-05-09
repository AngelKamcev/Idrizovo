<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Activity extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'content',
        'icon',
        'image_url',
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
        return $query->orderBy('sort_order', 'asc');
    }
}
