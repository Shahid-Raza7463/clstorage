<?php

namespace App\Listeners\Admin\Adspaces;

use App\Events\AdcreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdcreatedNotification
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
    public function handle(AdcreatedEvent $event): void
    {
        //
    }
}
