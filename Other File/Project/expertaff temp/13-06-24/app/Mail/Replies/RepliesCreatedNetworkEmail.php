<?php

namespace App\Mail\Replies;

use App\Models\User;
use App\Models\Web\Network;
use App\Models\Web\NetworkReviewModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RepliesCreatedNetworkEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $network_review;
    public $user;
    public $network;

    public function __construct(NetworkReviewModel $network_review, User $user, Network $network)
    {
        $this->network_review = $network_review;
        $this->user = $user;
        $this->network = $network;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Replies Created to Network',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'web.pages.email.replies.replies_created_network',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'reviewText' => $this->network_review->review_text
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
