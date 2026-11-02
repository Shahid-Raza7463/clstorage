<?php

namespace App\Listeners;

use App\Events\FeaturedUserEvent;
use App\Mail\FeaturedUserEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class FeaturedUserNotification implements ShouldQueue
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
    public function handle(FeaturedUserEvent $event): void
    {

        $user = $event->user;
        // send email
        Mail::to($user->email)->send(new FeaturedUserEmail($user));
    }
}
