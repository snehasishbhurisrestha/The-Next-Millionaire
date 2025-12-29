<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $fillable = ['title', 'description', 'type', 'price', 'offer_price', 'is_visible'];

    // Course has many contents (lessons/steps)
    public function contents()
    {
        return $this->hasMany(CourseContent::class);
    }

    // Course has many enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Course has one exam
    public function exam()
    {
        return $this->hasOne(Exam::class);
    }

    public function reviews()
    {
        return $this->hasMany(CourseReview::class);
    }
}
