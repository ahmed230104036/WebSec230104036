<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $temporaryPassword;
    private $name;

    public function __construct($temporaryPassword, $name)
    {
        $this->temporaryPassword = $temporaryPassword;
        $this->name = $name;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Reset Request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reset_password',
            with: [
                'temporaryPassword' => $this->temporaryPassword,
                'name' => $this->name
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
} 