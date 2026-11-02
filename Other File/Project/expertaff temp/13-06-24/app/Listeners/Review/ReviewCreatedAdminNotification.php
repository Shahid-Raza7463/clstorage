<?php

namespace App\Listeners\Review;

use App\Events\Review\ReviewCreatedAdmin;
use App\Mail\Review\ReviewCreatedAdminEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ReviewCreatedAdminNotification implements ShouldQueue
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
    public function handle(ReviewCreatedAdmin $event): void
    {
        $network_review = $event->network_review;
        $user = $event->user;

        // find admin who belong to admin
        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ReviewCreatedAdminEmail($network_review, $user));
        }
    }
}
