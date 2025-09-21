<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'veterinarian_id',
        'patient_name',
        'patient_breed',
        'patient_weight',
        'blood_type_needed',
        'urgency_level',
        'medical_reason',
        'clinic_contact',
        'needed_by_date',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'patient_weight' => 'decimal:2',
            'needed_by_date' => 'datetime',
        ];
    }

    // RELACIONES
    public function veterinarian()
    {
        return $this->belongsTo(User::class, 'veterinarian_id');
    }

    public function donationResponses()
    {
        return $this->hasMany(DonationResponse::class);
    }

    // ACCESSORS
    public function getUrgencyColorAttribute()
    {
        return match($this->urgency_level) {
            'critica' => 'danger',
            'alta' => 'warning',
            'media' => 'info',
            'baja' => 'secondary',
            default => 'secondary'
        };
    }

    public function getTimeRemainingAttribute()
    {
        return $this->needed_by_date->diffForHumans();
    }

    public function getInterestedDonorsCountAttribute()
    {
        return $this->donationResponses()->where('response', 'interested')->count();
    }

    public function markAsFulfilled()
    {
        $this->update(['status' => 'fulfilled']);
    }
}