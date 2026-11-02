<?php

namespace App\Listeners;

use App\Events\AfterVerifyNetwork;
use App\Mail\AfterVerifyNetworkEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class AfterVerifyNetworkNotification implements ShouldQueue
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
    public function handle(AfterVerifyNetwork $event): void
    {
        //
        // Access the user from the event
        $user = $event->user;
        // Send the email
        Mail::to($user->email)->send(new AfterVerifyNetworkEmail($user));
    }
}
