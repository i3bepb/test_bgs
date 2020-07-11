<?php

namespace App\Events;

use App\Member;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AfterCreateMember
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $member;

    /**
     * Create a new event instance.
     * @param Member $member
     * @return void
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
