<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrivateMessageSent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return new Channel('private.chat.' . $this->message->chat_id);
    }

    public function broadcastAs()
    {
        return 'PrivateMessageSent';
    }
}
