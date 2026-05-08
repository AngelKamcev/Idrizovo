<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $fillable = [
        'submitted_by_name',
        'submitted_by_email',
        'submitted_by_phone',
        'subject',
        'message',
        'status',
        'assigned_to',
    ];
}
