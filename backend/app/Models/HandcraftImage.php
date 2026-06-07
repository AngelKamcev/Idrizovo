<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandcraftImage extends Model
{
    protected $table = 'handcraft_images';

    protected $fillable = [
        'handcraft_id',
        'image_url',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function handcraft()
    {
        return $this->belongsTo(Handcraft::class, 'handcraft_id');
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
}
