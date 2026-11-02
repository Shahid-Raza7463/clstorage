<?php

namespace App\Mail\Review;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User; // Import the User model if not already imported

class ReviewVerifyUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $network_review;
    protected $token;

    public function __construct(User $user, $network_review, $token)
    {
        $this->user = $user;
        $this->network_review = $network_review;
        $this->token = $token;
    }

    // ...

    public function content(): Content
    {
        return new Content(
            view: 'web.pages.email.reviews.reviewverifyuser',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'reviewText' => $this->network_review->review_text,
                'token' => $this->token
            ],
        );
    }

    // ...
}
