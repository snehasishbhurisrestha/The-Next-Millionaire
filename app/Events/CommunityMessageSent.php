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
        $this->message = $message;
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
        return [
            'message' => [
                'id' => $this->message->id,
                'user_id' => $this->message->user_id,
                'message' => $this->message->message,
                'avatar' => $avatar,
                'is_pinned' => $this->message->is_pinned,
                'created_at' => $this->message->created_at->diffForHumans(),
                'user' => [
                    'name' => $this->message->user->name ?? 'User'
                ]
            ]
        ];
    }
}
