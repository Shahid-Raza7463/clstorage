<?php

namespace App\Listeners\Admin;

use App\Events\Admin\NetworkApprovedAdmin;
use App\Mail\Admin\NetworkApprovedAdminEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NetworkApprovedAdminNotification implements ShouldQueue
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
    public function handle(NetworkApprovedAdmin $event): void
    {
        // Access the newUser from the event
        $admins = $event->admins;
        $newUser = $event->newUser;
        // Send the email to each admin
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NetworkApprovedAdminEmail($admin, $newUser));
        }
    }
}
