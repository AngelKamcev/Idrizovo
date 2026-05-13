<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitRequest extends Model
{
    protected $table = 'visit_requests';

    protected $fillable = [
        'visitor_first_name',
        'visitor_last_name',
        'visitor_email',
        'visitor_phone',
        'visitor_relation_type',
        'inmate_id',
        'requested_inmate_number',
        'visit_date',
        // 'visit_schedule_id',
        'time_slot_id',
        'status',
        'cancel_deadline',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'cancel_deadline' => 'datetime',
    ];

    public function visitSchedule()
    {
        return $this->belongsTo(VisitSchedule::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function companions()
    {
        return $this->hasMany(VisitCompanion::class, 'visit_id');
    }
}
