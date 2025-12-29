<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Course Show', only: ['index','show']),
            new Middleware('permission:Course Create', only: ['create','store']),
            new Middleware('permission:Course Edit', only: ['edit','update']),
            new Middleware('permission:Course Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $courses = Course::all();
        return view('admin.cource_and_exams.cource.index',compact('courses'));
    }

    public function create()
    {
        return view('admin.cource_and_exams.cource.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            // 'video_url' => 'required',
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:51200',
            // NEW — receive tus uploaded file path
            'uploaded_video_path' => 'nullable|string',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $course = new Course();
            $course->title = $request->name;
            $course->slug = createSlug($request->name,Course::class);
            $course->description = $request->description;
            // $course->type = $request->type;
            $course->type = 'paid';
            $course->price = $request->price;
            $course->offer_price = $request->offer_price;
            $course->video_url = $request->video_url;
            $course->is_visible = $request->is_visible;
            if ($request->hasFile('image')) {
                $course->addMedia($request->file('image'))->toMediaCollection('course-image');
            }
            if ($request->hasFile('video')) {
                $course->addMedia($request->file('video'))->toMediaCollection('course-video');
            }

            if ($request->uploaded_video_path) {

                $fileId = basename($request->uploaded_video_path);

                $disk = config('tus.storage_disk', 'local');
                $dir  = trim(config('tus.storage_path', 'tus'), '/');

                // relative path used by disk
                $relative = "{$dir}/{$fileId}.mp4";

                if (! Storage::disk($disk)->exists($relative)) {
                    return back()->with('error', "Uploaded video not found: " . Storage::disk($disk)->path($relative))
                                ->withInput();
                }

                $absolutePath = Storage::disk($disk)->path($relative);

                $course->addMedia($absolutePath)->toMediaCollection('course-video');
            }

            $res = $course->save();
            if($res){
                return back()->with('success','Cource Created Successfully');
            }else{
                return back()->with('error','Cource Not Created');
            }
        }
    }

    public function show(Course $course)
    {
        //
    }

    public function edit(string $id)
    {
        $item = Course::findOrFail($id);
        return view('admin.cource_and_exams.cource.edit',compact('item'));
    }

    /*public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'required',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $course = Course::findOrFail($id);
            if($course->title != $request->name){
                $course->slug = createSlug($request->name,Course::class);
            }
            $course->title = $request->name;
            $course->description = $request->description;
            // $course->type = $request->type;
            $course->type = 'paid';
            $course->price = $request->price;
            $course->offer_price = $request->offer_price;
            $course->video_url = $request->video_url;
            $course->is_visible = $request->is_visible;
            if ($request->hasFile('image')) {
                $course->clearMediaCollection('course-image');
                $course->addMedia($request->file('image'))->toMediaCollection('course-image');
            }

            $res = $course->update();
            if($res){
                return back()->with('success','Course Updated Successfully');
            }else{
                return back()->with('error','Course Not Updated');
            }
        }
    }*/

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',

            // tus upload
            'uploaded_video_path' => 'nullable|string',

            'is_visible' => 'required|in:1,0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $course = Course::findOrFail($id);

        // update basic fields
        if ($course->title != $request->name) {
            $course->slug = createSlug($request->name, Course::class);
        }

        $course->title = $request->name;
        $course->description = $request->description;
        $course->type = 'paid';
        $course->price = $request->price;
        $course->offer_price = $request->offer_price;
        if($request->video_url){
            $course->video_url = $request->video_url;
        }
        $course->is_visible = $request->is_visible;

        /**
         * =============================
         * IMAGE UPDATE
         * =============================
         */
        if ($request->hasFile('image')) {
            $course->clearMediaCollection('course-image');
            $course->addMedia($request->file('image'))->toMediaCollection('course-image');
        }


        /**
         * =============================
         * VIDEO UPDATE (TUS + SPATIE)
         * =============================
         */
        if ($request->uploaded_video_path) {

            $fileId = basename($request->uploaded_video_path);

            $disk = config('tus.storage_disk', 'local');
            $dir  = trim(config('tus.storage_path', 'tus'), '/');

            $relative = "{$dir}/{$fileId}.mp4";

            if (! Storage::disk($disk)->exists($relative)) {
                return back()->with(
                    'error',
                    "Uploaded video not found: " . Storage::disk($disk)->path($relative)
                )->withInput();
            }

            $absolutePath = Storage::disk($disk)->path($relative);

            // remove old video
            $course->clearMediaCollection('course-video');

            // attach new video
            $course->addMedia($absolutePath)->toMediaCollection('course-video');
        }


        /**
         * =============================
         * SAVE
         * =============================
         */
        $course->save();

        return back()->with('success', 'Course Updated Successfully');
    }


    public function destroy(string $id)
    {
        $item = Course::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }
}
