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
        'tutor_id',
        'response',
        'notes',
        'responded_at'
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
        ];
    }

    // RELACIONES
    public function bloodRequest()
    {
        return $this->belongsTo(BloodRequest::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    // ACCESSORS
    public function getResponseColorAttribute()
    {
        return match($this->response) {
            'interested' => 'success',
            'completed' => 'primary',
            'not_available' => 'secondary',
            default => 'secondary'
        };
    }

    public function getResponseDisplayAttribute()
    {
        return match($this->response) {
            'interested' => 'Interesado',
            'completed' => 'Completado',
            'not_available' => 'No disponible',
            default => $this->response
        };
    }
}