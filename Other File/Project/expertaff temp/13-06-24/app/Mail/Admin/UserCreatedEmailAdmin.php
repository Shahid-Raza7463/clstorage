<?php

namespace App\Mail\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCreatedEmailAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $admins;
    protected $newUser;
    /**
     * Create a new message instance.
     */
    public function __construct($admins, $newUser)
    {
        $this->admins = $admins;
        $this->newUser = $newUser;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Created Email to Admin',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'web.pages.email.usercreated',
            with: [
                // 'adminName' => $this->admins->name,
                'userName' => $this->newUser->name,
                'userEmail' => $this->newUser->email,
            ],
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
