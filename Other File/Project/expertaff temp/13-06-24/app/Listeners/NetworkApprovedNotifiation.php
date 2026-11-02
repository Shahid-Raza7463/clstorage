<?php

namespace App\Listeners;

use App\Events\NetworkApproved;
use App\Mail\NetworkApprovedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NetworkApprovedNotifiation implements ShouldQueue
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
    public function handle(NetworkApproved $event): void
    {
        // Access the newUser from the event
        $newUser = $event->newUser;
        // Send the email
        Mail::to($newUser->email)->send(new NetworkApprovedEmail($newUser));
    }
}
