<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\BloodRequest;
use App\Models\Pet;

class BloodDonationRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bloodRequest;
    public $pet;

    public function __construct(BloodRequest $bloodRequest, Pet $pet)
    {
        $this->bloodRequest = $bloodRequest;
        $this->pet = $pet;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🆘 Solicitud Urgente de Donación de Sangre para ' . $this->bloodRequest->patient_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.blood-donation-request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}