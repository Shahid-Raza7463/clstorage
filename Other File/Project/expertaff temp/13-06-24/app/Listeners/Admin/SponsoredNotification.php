<?php

namespace App\Listeners\Admin;

use App\Events\Admin\SponsoredEvent;
use App\Mail\Admin\SponsoredEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SponsoredNotification implements ShouldQueue
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
    public function handle(SponsoredEvent $event): void
    {
        $user = $event->user;

        // find admin who belong to admin
        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new SponsoredEmail($user));
        }
    }
}
