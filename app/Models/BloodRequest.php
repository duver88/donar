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
        'patient_species',
        'patient_breed',
        'patient_age',
        'patient_weight',
        'blood_type',
        'blood_type_needed',
        'quantity_needed',
        'urgency_level',
        'medical_reason',
        'additional_notes',
        'clinic_contact',
        'needed_by_date',
        'status',
        'admin_notes',
        'completed_at',
        'updated_by_admin'
    ];

    protected function casts(): array
    {
        return [
            'patient_weight' => 'decimal:2',
            'needed_by_date' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    // ========================================
    // RELACIONES
    // ========================================

    public function veterinarian()
    {
        return $this->belongsTo(Veterinarian::class, 'veterinarian_id');
    }

    public function donationResponses()
    {
        return $this->hasMany(DonationResponse::class);
    }

    public function updatedByAdmin()
    {
        return $this->belongsTo(User::class, 'updated_by_admin');
    }

    public function history()
    {
        return $this->hasMany(BloodRequestHistory::class)->orderBy('created_at', 'desc');
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