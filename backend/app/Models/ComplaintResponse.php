<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintResponse extends Model
{
    protected $table = 'complaint_responses';

    protected $fillable = [
        'complaint_id',
        'responded_by',
        'message',
    ];

    public $timestamps = true;
    const UPDATED_AT = null;

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}
