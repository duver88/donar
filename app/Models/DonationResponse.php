<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'blood_request_id',
        'pet_id',
        'user_id',
        'response',
        'response_type',
        'status',
        'message',
        'decline_reason',
        'responded_at',
        'contacted_at',
        'donation_completed_at',
        'completion_notes'
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
            'contacted_at' => 'datetime',
            'donation_completed_at' => 'datetime',
        ];
    }

    // ========================================
    // RELACIONES
    // ========================================
    
    public function bloodRequest()
    {
        return $this->belongsTo(BloodRequest::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ========================================
    // SCOPES
    // ========================================
    
    public function scopeAccepted($query)
    {
        return $query->where('response_type', 'accepted');
    }
    
    public function scopeDeclined($query)
    {
        return $query->where('response_type', 'declined');
    }
    
    public function scopeForBloodRequest($query, $bloodRequestId)
    {
        return $query->where('blood_request_id', $bloodRequestId);
    }

    public function scopeCompleted($query)
    {
        return $query->whereNotNull('donation_completed_at');
    }

    public function scopePending($query)
    {
        return $query->where('response_type', 'accepted')
            ->whereNull('donation_completed_at');
    }

    // ========================================
    // ACCESSORS
    // ========================================
    
    public function getIsAcceptedAttribute()
    {
        return $this->response_type === 'accepted';
    }
    
    public function getIsDeclinedAttribute()
    {
        return $this->response_type === 'declined';
    }

    public function getIsCompletedAttribute()
    {
        return !is_null($this->donation_completed_at);
    }

    public function getStatusTextAttribute()
    {
        if ($this->response_type === 'declined') {
            return 'Rechazada';
        }
        
        if ($this->is_completed) {
            return 'Completada';
        }
        
        if ($this->contacted_at) {
            return 'Contactado';
        }
        
        return 'Pendiente';
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status_text) {
            case 'Completada':
                return 'success';
            case 'Contactado':
                return 'info';
            case 'Pendiente':
                return 'warning';
            case 'Rechazada':
                return 'secondary';
            default:
                return 'primary';
        }
    }
}