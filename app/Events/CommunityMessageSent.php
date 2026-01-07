<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommunityMessageSent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return new Channel('community.global');
    }

    public function broadcastAs()
    {
        return 'CommunityMessageSent';
    }
}
