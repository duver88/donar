<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pet;
use App\Models\BloodRequest;

class PetApprovedWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pet;
    public $activeRequests;

    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
        // Obtener solicitudes activas urgentes
        $this->activeRequests = BloodRequest::where('status', 'active')
                                           ->whereIn('urgency_level', ['alta', 'critica'])
                                           ->latest()
                                           ->take(3)
                                           ->get();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Bienvenido! ' . $this->pet->name . ' ya es un héroe donante 🐕',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pet-approved-welcome',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}