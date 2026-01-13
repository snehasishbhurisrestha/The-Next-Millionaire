<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrivateMessage extends Model
{
    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
        'reply_to_id'
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(PrivateChat::class, 'chat_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(PrivateMessage::class, 'reply_to_id');
    }
    
}