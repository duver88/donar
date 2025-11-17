<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetHealthCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',                    
        'has_diagnosed_disease',
        'under_medical_treatment',
        'recent_surgery',
        'diseases'
    ];

    protected function casts(): array
    {
        return [
            'has_diagnosed_disease' => 'boolean',
            'under_medical_treatment' => 'boolean',
            'recent_surgery' => 'boolean',
            'diseases' => 'array',
        ];
    }

    // RELACIONES
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}