<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inmate extends Model
{
    protected $table = 'inmates';

    protected $fillable = [
        'inmate_number',
        'first_name',
        'last_name',
        'status',
        'notes',
    ];
}
