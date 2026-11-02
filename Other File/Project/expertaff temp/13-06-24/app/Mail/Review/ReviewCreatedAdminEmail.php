<?php

namespace App\Mail\Review;

use App\Models\User;
use App\Models\Web\NetworkReviewModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewCreatedAdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $network_review;
    public $user;

    public function __construct(NetworkReviewModel $network_review, User $user)
    {
        $this->network_review = $network_review;
        $this->user = $user;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Review Created to Admin',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'web.pages.email.reviews.review_created_admin',
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
