<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePayments extends Model
{
    protected $fillable = ['user_id', 'course_id', 'amount', 'status'];
}
