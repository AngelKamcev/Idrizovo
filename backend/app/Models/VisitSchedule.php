<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitSchedule extends Model
{
    protected $fillable = [
        'group_name',
        'days_label',
        'time_range',
        'sort_order',
        'is_active',
    ];
}
