<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrivateChat extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */
    public function messages(): HasMany
    {
        return $this->hasMany(PrivateMessage::class, 'chat_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }

    public function otherUser()
    {
        return $this->sender_id == auth()->id()
            ? $this->receiver
            : $this->sender;
    }

    public static function firstOrCreatePrivate($user1, $user2)
    {
        $chat = self::where(function ($q) use ($user1, $user2) {
            $q->where('sender_id', $user1)
            ->where('receiver_id', $user2);
        })->orWhere(function ($q) use ($user1, $user2) {
            $q->where('sender_id', $user2)
            ->where('receiver_id', $user1);
        })->first();

        if (!$chat) {
            $chat = self::create([
                'sender_id' => $user1,
                'receiver_id' => $user2,
            ]);
        }

        return $chat;
    }

}
