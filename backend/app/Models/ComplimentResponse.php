<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplimentResponse extends Model
{
    protected $table = 'compliment_responses';

    protected $fillable = [
        'compliment_id',
        'responded_by',
        'message',
    ];

    public $timestamps = true;
    const UPDATED_AT = null;

    public function compliment()
    {
        return $this->belongsTo(Compliment::class);
    }

    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}
