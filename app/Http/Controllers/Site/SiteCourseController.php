<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Course;

class SiteCourseController extends Controller
{
    public function index(){
        $courses = Course::where('is_visible',1)->orderBy('id','desc')->get();
        return view('site.course',compact('courses'));
    }

    public function course_details(string $slug){
        $course = Course::where('slug',$slug)->first();
        if($course){
            return view('site.course_details',compact('course'));
        }else{
            return back()->with('error','Not Found');
        }
    }

}