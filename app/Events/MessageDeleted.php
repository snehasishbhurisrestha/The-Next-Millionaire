<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $messageId;
    public $chatId;
    public $time;
    public $connection = 'sync';

    public function __construct($messageId, $chatId, $time)
    {
        $this->messageId = $messageId;
        $this->chatId = $chatId;
        $this->time = $time;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('private.chat.' . $this->chatId);
    }

    public function broadcastAs()
    {
        return 'MessageDeleted';
    }
}

