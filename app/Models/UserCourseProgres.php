<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourseProgres extends Model
{
    protected $fillable = ['user_id', 'course_id', 'course_content_id', 'is_completed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function content()
    {
        return $this->belongsTo(CourseContent::class, 'course_content_id');
    }
}
