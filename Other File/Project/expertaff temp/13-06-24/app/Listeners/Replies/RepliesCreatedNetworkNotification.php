<?php

namespace App\Listeners\Replies;

use App\Events\Replies\RepliesCreatedNetwork;
use App\Events\Review\ReviewCreatedNetwork;
use App\Mail\Replies\RepliesCreatedNetworkEmail;
use App\Mail\Review\ReviewCreatedNetworkEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class RepliesCreatedNetworkNotification implements ShouldQueue
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
    public function handle(RepliesCreatedNetwork $event): void
    {
        $network_review = $event->network_review;
        $user = $event->user;
        $network = $event->network;

        // get network user
        $networkUser = User::find($network->user_id);
        Mail::to($networkUser->email)->send(new RepliesCreatedNetworkEmail($network_review, $user, $network));
        // pass parameter sequencely
    }
}
