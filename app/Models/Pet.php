<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'name',
        'breed',
        'species',
        'age_years',
        'weight_kg',
        'blood_type',
        'health_status',
        'vaccines_up_to_date',
        'has_donated_before',
        'photo_path',
        'donor_status',
        'rejection_reason',
        'approved_at'
    ];

    protected function casts(): array
    {
        return [
            'vaccines_up_to_date' => 'boolean',
            'has_donated_before' => 'boolean',
            'weight_kg' => 'decimal:2',
            'approved_at' => 'datetime',
        ];
    }

    // ========================================
    // RELACIONES
    // ========================================

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    // Alias para compatibilidad
    public function user()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function healthConditions()
    {
        return $this->hasMany(PetHealthCondition::class);
    }

    public function donationResponses()
    {
        return $this->hasMany(DonationResponse::class);
    }

    // ========================================
    // SCOPES
    // ========================================
    
    public function scopeApprovedDonors($query)
    {
        return $query->where('donor_status', 'approved');
    }

    public function scopeDogs($query)
    {
        return $query->where('species', 'perro');
    }

    public function scopeEligibleWeight($query)
    {
        return $query->where('weight_kg', '>=', 25);
    }

    public function scopeByCity($query, $city)
    {
        return $query->whereHas('tutor', function($q) use ($city) {
            $q->where('city', $city);
        });
    }

    // ========================================
    // ACCESSORS
    // ========================================
    
    public function getPhotoUrlAttribute()
    {
        return $this->photo_path ? Storage::url($this->photo_path) : null;
    }

    public function getAgeDisplayAttribute()
    {
        return $this->age_years . ($this->age_years == 1 ? ' año' : ' años');
    }

    public function getWeightDisplayAttribute()
    {
        return $this->weight_kg . ' kg';
    }

    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'pending' => 'En revisión',
            'approved' => 'Aprobado como donante',
            'rejected' => 'No apto para donación',
            'inactive' => 'Inactivo temporalmente'
        ];

        return $statuses[$this->donor_status] ?? $this->donor_status;
    }

    public function getCanDonateAttribute()
    {
        return $this->donor_status === 'approved' && 
               $this->vaccines_up_to_date && 
               $this->weight_kg >= 25;
    }
}