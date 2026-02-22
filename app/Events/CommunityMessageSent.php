<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommunityMessageSent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;
    public $connection = 'sync';

    public function __construct($message)
    {
        // $this->message = $message;
        $this->message = $message->load('replyTo.user');
    }

    public function broadcastOn()
    {
        return new Channel('community.global');
    }

    public function broadcastAs()
    {
        return 'CommunityMessageSent';
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
                'is_pinned' => $this->message->is_pinned,
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
