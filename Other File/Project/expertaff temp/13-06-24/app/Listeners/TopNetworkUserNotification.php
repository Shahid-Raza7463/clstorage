<?php

namespace App\Listeners;

use App\Events\TopNetworkUserEvent;
use App\Mail\TopNetworkUserEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class TopNetworkUserNotification implements ShouldQueue
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
    public function handle(TopNetworkUserEvent $event): void
    {
        $user = $event->user;
        // send email
        Mail::to($user->email)->send(new TopNetworkUserEmail($user));
    }
}
