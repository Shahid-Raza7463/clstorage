<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\UserCreatedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserCreatedNotification implements ShouldQueue
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
    public function handle(UserCreated $event): void
    {
        // Access the newUser from the event
        $newUser = $event->newUser;
        // Send the email
        Mail::to($newUser->email)->send(new UserCreatedEmail($newUser));
    }
}
   // $event->newUser;