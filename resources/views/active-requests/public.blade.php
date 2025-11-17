<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pet;

class ActiveRequestsListMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pet;
    public $activeRequests;
    public $showInEmail;
    public $maxRequestsInEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(Pet $pet, $activeRequests)
    {
        $this->pet = $pet;
        $this->activeRequests = $activeRequests;
        $this->maxRequestsInEmail = 5; // Configurable
        $this->showInEmail = $activeRequests->count() <= $this->maxRequestsInEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $count = $this->activeRequests->count();
        
        return new Envelope(
            subject: "🩸 {$count} casos activos necesitan donación de sangre tipo {$this->pet->blood_type}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.active-requests-list',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}