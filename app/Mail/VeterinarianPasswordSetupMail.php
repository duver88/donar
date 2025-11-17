<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VeterinarianPasswordSetupMail extends Mailable
{
    use Queueable, SerializesModels;

    public $veterinarian;
    public $resetToken;
    public $resetUrl;

    public function __construct(User $veterinarian, string $resetToken)
    {
        $this->veterinarian = $veterinarian;
        $this->resetToken = $resetToken;
        $this->resetUrl = url('password/reset/' . $resetToken) . '?email=' . urlencode($veterinarian->email);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔐 Configura tu contraseña - Banco de Sangre Canina',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.veterinarian-password-setup',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
