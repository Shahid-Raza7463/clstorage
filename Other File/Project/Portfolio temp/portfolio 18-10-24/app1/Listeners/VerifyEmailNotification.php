<?php

// app/Listeners/VerifyEmailNotification.php

namespace App\Listeners;

use App\Events\VerifyEmailEvent;
use App\Mail\VerifyEmailAddress;
use Illuminate\Auth\Events\Registered;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class VerifyEmailNotification implements ShouldQueue
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
    public function handle(VerifyEmailEvent $event): void
    {
        // Access the newUser from the event
        $newUser = $event->newUser;
        // Send the email using the custom notification
        $newUser->notify(new VerifyEmailAddress($newUser));
    }
}
