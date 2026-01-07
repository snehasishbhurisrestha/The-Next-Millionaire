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
}
