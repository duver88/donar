<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VeterinarianApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $veterinarian;

    public function __construct(User $veterinarian)
    {
        $this->veterinarian = $veterinarian;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Tu cuenta de veterinario ha sido aprobada',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.veterinarian-approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}