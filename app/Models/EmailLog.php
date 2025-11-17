<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'to_email',
        'to_name',
        'subject',
        'mailable_class',
        'data',
        'status',
        'error_message',
        'sent_at'
    ];

    protected $casts = [
        'data' => 'array',
        'sent_at' => 'datetime'
    ];

    // ========================================
    // RELACIONES
    // ========================================

    // Podríamos agregar relaciones si necesitamos trackear quién envió el email
    // public function sentBy()
    // {
    //     return $this->belongsTo(User::class, 'sent_by');
    // }
}