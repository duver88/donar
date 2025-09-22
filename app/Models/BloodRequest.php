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
        return $this->belongsTo(User::class, 'veterinarian_id')
                    ->where('role', 'veterinarian')
                    ->with('veterinarian'); // Cargar el perfil de veterinario
    }

    // Relación auxiliar para obtener el perfil del veterinario
    public function veterinarianProfile()
    {
        return $this->hasOneThrough(
            Veterinarian::class,
            User::class,
            'id',           // Foreign key en users
            'user_id',      // Foreign key en veterinarians
            'veterinarian_id', // Local key en blood_requests
            'id'            // Local key en users
        );
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

    // ========================================
    // SCOPES
    // ========================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeClosed($query)
    {
        return $query->whereIn('status', ['completed', 'cancelled', 'expired']);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCritical($query)
    {
        return $query->where('urgency_level', 'critica');
    }

    public function scopeExpiredByDate($query)
    {
        return $query->where('status', 'active')
                    ->where('needed_by_date', '<', now());
    }

    // ========================================
    // MÉTODOS DE ESTADO
    // ========================================

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isExpired()
    {
        return $this->status === 'expired' ||
               ($this->status === 'active' && $this->needed_by_date < now());
    }

    public function isClosed()
    {
        return in_array($this->status, ['completed', 'cancelled', 'expired']);
    }

    public function getStatusDisplayAttribute()
    {
        return match($this->status) {
            'active' => 'Activa',
            'completed' => 'Completada',
            'cancelled' => 'Cancelada',
            'expired' => 'Expirada',
            default => ucfirst($this->status)
        };
    }

    /**
     * Marca solicitudes activas como expiradas si han pasado la fecha límite
     */
    public static function markExpiredRequests()
    {
        $expiredCount = self::where('status', 'active')
            ->where('needed_by_date', '<', now())
            ->update([
                'status' => 'expired',
                'updated_at' => now()
            ]);

        return $expiredCount;
    }
}