<?php

namespace App\Listeners\Review;

use App\Events\Review\ReviewCreatedNetwork;
use App\Mail\Review\ReviewCreatedNetworkEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ReviewCreatedNetworkNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReviewCreatedNetwork $event): void
    {
        $network_review = $event->network_review;
        $user = $event->user;
        $network = $event->network;

        // get network user
        $networkUser = User::find($network->user_id);
        Mail::to($networkUser->email)->send(new ReviewCreatedNetworkEmail($network_review, $user, $network));
        // pass parameter sequencely
    }
}
