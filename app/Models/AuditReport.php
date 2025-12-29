<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AuditReport extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function user()
    {
        return $this->belongsTo(User::class,'uploaded_by', 'id');
    }
}
