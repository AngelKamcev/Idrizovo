<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitCompanion extends Model
{
    protected $table = 'visit_companions';

    public $timestamps = false;

    protected $fillable = [
        'visit_id',
        'first_name',
        'last_name',
        'relation_to_visitor',
        'is_child',
    ];

    protected $casts = [
        'is_child' => 'boolean',
    ];
}
