<?php

namespace App\Events\Review;

use App\Models\User;
use App\Models\Web\NetworkReviewModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReviewCreatedAdmin
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $network_review;
    public $user;

    public function __construct(NetworkReviewModel $network_review, User $user)
    {
        $this->network_review = $network_review;
        $this->user = $user;
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
