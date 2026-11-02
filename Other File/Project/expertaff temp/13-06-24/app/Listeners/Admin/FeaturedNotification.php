<?php

namespace App\Listeners\Admin;

use App\Events\Admin\FeaturedEvent;
use App\Mail\Admin\FeaturedEmai;
use App\Mail\Admin\FeaturedEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class FeaturedNotification implements ShouldQueue
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
    public function handle(FeaturedEvent $event): void
    {
        $user = $event->user;

        // find admin who belong to admin
        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new FeaturedEmail($user));
        }
    }
}
