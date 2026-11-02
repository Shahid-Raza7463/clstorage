<?php

namespace App\Listeners\Admin\Adspaces;

use App\Events\AdupdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdupdatedNotification
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
    public function handle(AdupdatedEvent $event): void
    {
        //
    }
}
