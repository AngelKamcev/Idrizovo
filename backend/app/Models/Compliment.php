<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compliment extends Model
{
    protected $table = 'compliments';

    protected $fillable = [
        'submitted_by_name',
        'submitted_by_email',
        'submitted_by_phone',
        'subject',
        'message',
        'status',
        'assigned_to',
    ];

    public function responses()
    {
        return $this->hasMany(ComplimentResponse::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
