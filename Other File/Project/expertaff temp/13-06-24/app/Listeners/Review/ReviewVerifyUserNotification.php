<?php

namespace App\Listeners\Review;

use Illuminate\Support\Str;
use App\Events\Review\ReviewVerifyUser;
use App\Jobs\ReviewRatingCounterJob;
use App\Mail\Review\ReviewVerifyUserEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class ReviewVerifyUserNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
    public function handle(ReviewVerifyUser $event)
    {
        $network_review = $event->network_review;
        $user = $event->user;

        // get encrypt functionality
        $token = ($network_review->review_id . "_" . $network_review->user_id . "_" . $network_review->network_id . "_" . $network_review->created_at);

        $token = Crypt::encryptString($token);

        Mail::to($user->email)->send(new ReviewVerifyUserEmail($user, $network_review, $token));

        // ReviewRatingCounterJob::dispatch($network_review->network_id);
    }
}
