<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Veterinarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'professional_card',
        'professional_card_photo',
        'specialty',
        'clinic_name',
        'clinic_address',
        'city',
        'years_experience',
        'rejection_reason',
        'approved_at',
        'approved_by'
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
        ];
    }

    // ========================================
    // RELACIONES
    // ========================================
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function bloodRequests()
    {
        return $this->hasMany(BloodRequest::class);
    }

    // ========================================
    // ACCESSORS
    // ========================================
    
    public function getFullClinicInfoAttribute()
    {
        return "{$this->clinic_name} - {$this->clinic_address}, {$this->city}";
    }

    // ← AGREGAR ESTE NUEVO ACCESSOR
    public function getProfessionalCardPhotoUrlAttribute()
    {
        return $this->professional_card_photo 
            ? Storage::url($this->professional_card_photo) 
            : null;
    }
}