<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequestHistory extends Model
{
    use HasFactory;

    protected $table = 'blood_request_history';

    protected $fillable = [
        'blood_request_id',
        'previous_status',
        'new_status',
        'changed_by',
        'change_reason'
    ];

    // ========================================
    // RELACIONES
    // ========================================

    public function bloodRequest()
    {
        return $this->belongsTo(BloodRequest::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
