<?php

namespace App\Listeners;

use App\Events\SponsoredUserEvent;
use App\Mail\SponsoredUserEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SponsoredUserNotification implements ShouldQueue
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
    public function handle(SponsoredUserEvent $event): void
    {
        $user = $event->user;
        // send email
        Mail::to($user->email)->send(new SponsoredUserEmail($user));
    }
}
