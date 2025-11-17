<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'document_id',
        'role',
        'status',
        'password',
        'approved_at',
        'approved_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ========================================
    // RELACIONES
    // ========================================
    
    public function pets()
    {
        return $this->hasMany(Pet::class, 'tutor_id');
    }

    public function veterinarian()
    {
        return $this->hasOne(Veterinarian::class);
    }

    public function bloodRequests()
    {
        return $this->hasManyThrough(BloodRequest::class, Veterinarian::class, 'user_id', 'veterinarian_id');
    }

    public function donationResponses()
    {
        return $this->hasMany(DonationResponse::class, 'user_id');
    }

    // ========================================
    // SCOPES
    // ========================================
    
    public function scopeVeterinarians($query)
    {
        return $query->where('role', 'veterinarian');
    }

    public function scopeTutors($query)
    {
        return $query->where('role', 'tutor');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // ========================================
    // ACCESSORS
    // ========================================
    
    public function getIsVeterinarianAttribute()
    {
        return $this->role === 'veterinarian';
    }

    public function getIsTutorAttribute()
    {
        return $this->role === 'tutor';
    }

    public function getIsAdminAttribute()
    {
        return $this->role === 'super_admin';
    }

    public function getIsApprovedAttribute()
    {
        return $this->status === 'approved';
    }
}