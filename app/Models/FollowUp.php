<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function remarkedBy()
    {
        return $this->belongsTo(User::class, 'remarked_by', 'id');
    }
}
