<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CertificationType extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'auditorspecializations',
            'certificate_id',
            'auditor_id'
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class); // Assumes category_id is the foreign key
    }
}
