<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $newUser;
    public function __construct(User $newUser)
    {
        //
        $this->newUser = $newUser;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
