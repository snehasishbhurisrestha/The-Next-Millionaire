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
    public $connection = 'sync';

    public function __construct($message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('private.chat.' . $this->message->chat_id);
    }

    public function broadcastAs()
    {
        return 'PrivateMessageSent';
    }
    
    public function broadcastWith()
    {
        $avatar = $this->message->user->getFirstMediaUrl('user-image');
    
        if (!$avatar || trim($avatar) === '') {
            $avatar = asset('assets/user-admin-assets/img/default-user.png');
        }
    
        return [
            'message' => [
                'id' => $this->message->id,
                'user_id' => $this->message->user_id,
                'message' => $this->message->message,
                'avatar' => $avatar,
                'created_at' => $this->message->created_at->diffForHumans(),
                'user' => [
                    'name' => $this->message->user->name ?? 'User'
                ]
            ]
        ];
    }

}
