<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handcraft extends Model
{
    protected $table = 'handcrafts';

    protected $fillable = [
        'category_slug',
        'title_mk',
        'title_al',
        'title_en',
        'description_mk',
        'description_al',
        'description_en',
        'image_url',
        'cover_image_url',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'published_at' => 'datetime',
    ];

    /**
     * The 4 fixed category slugs and their Macedonian labels.
     */
    public static array $categories = [
        'igla-konec'   => 'Уметност со игла и конец',
        'drvorez'      => 'Дрворез',
        'slikarstvo'   => 'Боја и перспектива: слики од работилницата',
        'grncharstvo'  => 'Грнчарство',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Helper: current locale title
     */
    public function getLocaleTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?: $this->title_mk;
    }

    /**
     * Helper: current locale description
     */
    public function getLocaleDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"description_{$locale}"} ?: $this->description_mk;
    }
}
