<?php

namespace App\Listeners\Replies;

use App\Events\Replies\RepliesCreatedAdmin;
use App\Events\Review\ReviewCreatedAdmin;
use App\Mail\Replies\RepliesCreatedAdminEmail;
use App\Mail\Review\ReviewCreatedAdminEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class RepliesCreatedAdminNotification implements ShouldQueue
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
    public function handle(RepliesCreatedAdmin $event): void
    {
        $network_review = $event->network_review;
        $user = $event->user;

        // find admin who belong to admin
        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new RepliesCreatedAdminEmail($network_review, $user));
        }
    }
}
