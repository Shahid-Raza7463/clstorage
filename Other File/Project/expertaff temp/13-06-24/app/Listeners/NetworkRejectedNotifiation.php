<?php

namespace App\Listeners;

use App\Events\NetworkRejected;
use App\Mail\NetworkRejectedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NetworkRejectedNotifiation implements ShouldQueue
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
    public function handle(NetworkRejected $event): void
    {
        // Access the newUser from the event
        $newUser = $event->newUser;
        // Send the email
        Mail::to($newUser->email)->send(new NetworkRejectedEmail($newUser));
    }
}
