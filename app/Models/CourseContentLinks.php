<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseContentLinks extends Model
{
    protected $fillable = [
        'course_contents_id',
        'link'
    ];

    // Relationship with CourseContents model
    public function courseContent()
    {
        return $this->belongsTo(CourseContents::class, 'course_contents_id');
    }
}
