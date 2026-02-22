<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityMessage extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'message',
        'is_pinned',
        'reply_to_id'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(CommunityMessage::class, 'reply_to_id');
    }

    public function canEdit(): bool
    {
        return now()->diffInMinutes($this->created_at) <= 5;
    }
}

