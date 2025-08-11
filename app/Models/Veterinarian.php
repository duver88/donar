<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veterinarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'professional_card',
        'specialty',
        'clinic_name',
        'clinic_address',
        'city',
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

    // ========================================
    // ACCESSORS
    // ========================================
    
    public function getFullClinicInfoAttribute()
    {
        return "{$this->clinic_name} - {$this->clinic_address}, {$this->city}";
    }
}