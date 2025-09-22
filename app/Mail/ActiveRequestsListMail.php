<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Collection;

class ActiveRequestsListMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pet;
    public $activeRequests;

    /**
     * Create a new message instance.
     */
    public function __construct(Pet $pet, Collection $activeRequests)
    {
        $this->pet = $pet;
        $this->activeRequests = $activeRequests;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $count = $this->activeRequests->count();
        $bloodType = $this->pet->blood_type ?? 'compatible';

        return new Envelope(
            subject: "🩸 {$count} casos activos necesitan donación de sangre tipo {$bloodType}",
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
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
