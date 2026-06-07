<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitConfirmation extends Model
{
    protected $table = 'visit_confirmations';

    public $timestamps = false;

    protected $fillable = [
        'visit_id',
        'confirmation_code',
        'qr_code_token',
        'pdf_url',
        'issued_at',
        'valid_until',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function visitRequest()
    {
        return $this->belongsTo(VisitRequest::class, 'visit_id');
    }
}