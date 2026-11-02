<?php

namespace App\Listeners;

use App\Events\NetworkCreated;
use App\Mail\NetworkCreatedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NetworkCreatedNotification implements ShouldQueue
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
    public function handle(NetworkCreated $event): void
    {
        // Access the user from the event
        $network = $event->network;
        $user = $event->user;
        // Send the email
        Mail::to($user->email)->send(new NetworkCreatedEmail($network, $user));
    }
}
