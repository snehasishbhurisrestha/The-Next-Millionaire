<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Course;
use App\Models\CourseContent;
use App\Models\UserCourseProgres;
use App\Models\Enrollment;

class LessonController extends Controller
{
    // public function learningPage($course_slug)
    public function learningPage(Request $request, $course_slug)
    {
        $course = Course::where('slug', $course_slug)->firstOrFail();

        // Fetch all lessons sorted by step number
        $lessons = $course->contents->sortBy('step_number');

        // Determine the current lesson
        $currentLesson = $request->lesson_id
            ? CourseContent::where('id', $request->lesson_id)
                ->where('course_id', $course->id)
                ->first()
            : $lessons->first();

        // Previous & Next lessons
        $prevLesson = CourseContent::where('course_id', $course->id)
            ->where('step_number', '<', $currentLesson->step_number)
            ->orderBy('step_number', 'desc')
            ->first();

        $nextLesson = CourseContent::where('course_id', $course->id)
            ->where('step_number', '>', $currentLesson->step_number)
            ->orderBy('step_number', 'asc')
            ->first();

        // Track progress only if logged in
        if (auth()->check()) {
            $userId = auth()->id();

            $existingProgress = UserCourseProgres::where([
                ['user_id', $userId],
                ['course_id', $course->id],
                ['course_content_id', $currentLesson->id]
            ])->first();

            if (!$existingProgress) {
                UserCourseProgres::create([
                    'user_id' => $userId,
                    'course_id' => $course->id,
                    'course_content_id' => $currentLesson->id,
                    'is_completed' => 0
                ]);
            } else {
                Enrollment::where('user_id', $userId)
                    ->where('course_id', $course->id)
                    ->where('status', 'enrolled')
                    ->update(['status' => 'in_progress']);

                $existingProgress->update(['is_completed' => 1]);
            }

            // Check completion status
            $totalLessons = $course->contents->count();
            $completedLessons = UserCourseProgres::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->where('is_completed', 1)
                ->count();

            if ($completedLessons >= $totalLessons) {
                Enrollment::where('user_id', $userId)
                    ->where('course_id', $course->id)
                    ->update(['status' => 'completed']);
            }
        }

        return view('site.user-dashboard.courses.learning', compact(
            'course', 'lessons', 'currentLesson', 'prevLesson', 'nextLesson'
        ));
    }
}