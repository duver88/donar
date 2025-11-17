<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\BloodRequest;
use App\Models\Pet;
use App\Models\DonationResponse;

class DonationAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bloodRequest;
    public $pet;
    public $donationResponse;

    /**
     * Create a new message instance.
     */
    public function __construct(BloodRequest $bloodRequest, Pet $pet, DonationResponse $donationResponse)
    {
        $this->bloodRequest = $bloodRequest;
        $this->pet = $pet;
        $this->donationResponse = $donationResponse;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "✅ {$this->pet->name} puede donar sangre para {$this->bloodRequest->patient_name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.donation-accepted',
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