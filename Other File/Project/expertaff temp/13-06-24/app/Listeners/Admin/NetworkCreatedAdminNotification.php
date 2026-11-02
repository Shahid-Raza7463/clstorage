<?php

namespace App\Listeners\Admin;

use App\Events\Admin\NetworkCreatedAdmin;
use App\Mail\Admin\NetworkCreatedAdminEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NetworkCreatedAdminNotification implements ShouldQueue
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
    public function handle(NetworkCreatedAdmin $event): void
    {
        // Access the user from the event
        $admins = $event->admins;
        $user = $event->user;
        $network = $event->network;
        // Send the email to each admin
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NetworkCreatedAdminEmail($admin, $user, $network));
        }
    }
}
