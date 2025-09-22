<?php

namespace App\Mail;

use App\Models\Pet;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPetRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pet;
    public $tutor;

    public function __construct(Pet $pet, $tutor = null)
    {
        $this->pet = $pet;
        $this->tutor = $tutor ?? $pet->user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva mascota registrada: ' . $this->pet->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-pet-registered',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}