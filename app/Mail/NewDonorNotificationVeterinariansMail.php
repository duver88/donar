<?php

namespace App\Mail;

use App\Models\Pet;
use App\Models\Veterinarian;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewDonorNotificationVeterinariansMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pet;
    public $veterinarian;

    /**
     * Create a new message instance.
     *
     * @param Pet $pet El nuevo donante registrado
     * @param Veterinarian $veterinarian El veterinario que recibirá la notificación
     */
    public function __construct(Pet $pet, Veterinarian $veterinarian)
    {
        $this->pet = $pet;
        $this->veterinarian = $veterinarian;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🐕 Nuevo Donante Disponible: ' . $this->pet->name . ' - Banco de Sangre Canina',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new-donor-notification-veterinarians',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}