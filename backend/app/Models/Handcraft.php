<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handcraft extends Model
{
    protected $table = 'handcrafts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'title_mk',
        'title_al',
        'title_en',
        'description_mk',
        'description_al',
        'description_en',
        'image_url',
        'is_published',
        'created_by',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function images()
    {
        return $this->hasMany(HandcraftImage::class, 'handcraft_id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function getResolvedImageUrlAttribute(): string
    {
        if (! $this->image_url) {
            return asset('images/bla.jpeg');
        }

        if (preg_match('/^https?:\/\//i', $this->image_url)) {
            return $this->image_url;
        }

        return asset('storage/' . ltrim($this->image_url, '/'));
    }

    public function allImageUrls(): array
    {
        $urls = [$this->resolved_image_url];

        foreach ($this->images as $image) {
            $urls[] = $image->resolved_image_url;
        }

        return array_values(array_filter($urls));
    }
}
