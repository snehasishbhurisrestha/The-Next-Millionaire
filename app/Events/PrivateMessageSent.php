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
        // $this->message = $message->load('user');
        $this->message = $message->load(['user', 'replyTo.user']);
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
        
        $reply = null;

        if ($this->message->replyTo) {
            $reply = [
                'id' => $this->message->replyTo->id,
                'user' => $this->message->replyTo->user->name ?? 'User',
                'text' => \Str::limit(strip_tags($this->message->replyTo->message), 60)
            ];
        }
    
        return [
            'message' => [
                'id' => $this->message->id,
                'user_id' => $this->message->user_id,
                'message' => $this->message->message,
                'avatar' => $avatar,
                'created_at' => $this->message->created_at->diffForHumans(),
                'time' => $this->message->created_at->format('h:i a'),
                'user' => [
                    'name' => $this->message->user->name ?? 'User'
                ],
                'reply' => $reply
            ]
        ];
    }

}
