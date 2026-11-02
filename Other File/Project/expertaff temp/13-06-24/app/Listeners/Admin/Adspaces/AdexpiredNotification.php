<?php

namespace App\Listeners\Admin\Adspaces;

use App\Events\AdexpiredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdexpiredNotification
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
    public function handle(AdexpiredEvent $event): void
    {
        //
    }
}
