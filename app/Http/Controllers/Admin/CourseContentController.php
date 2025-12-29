<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CourseContentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Course Content Show', only: ['index','show']),
            new Middleware('permission:Course Content Create', only: ['create','store']),
            new Middleware('permission:Course Content Edit', only: ['edit','update']),
            new Middleware('permission:Course Content Delete', only: ['destroy']),
        ];
    }

    public function index(string $course_id)
    {
        $contents = CourseContent::where('course_id', $course_id)
            ->orderBy('step_number')
            ->get();

        return view('admin.cource_and_exams.cource-content.index', compact('contents'));
    }

    public function create(string $course_id)
    {
        return view('admin.cource_and_exams.cource-content.create', compact('course_id'));
    }

    /*public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|max:255',
            'content_type' => 'required|in:text,video,pdf',
            'content' => 'nullable',
            'video_file' => 'nullable|mimes:mp4,mov,avi,webm|max:51200', // 50MB
            'pdf_file' => 'nullable|mimes:pdf|max:20480', // 20MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create new content
        $content = new CourseContent();
        $content->course_id = $request->course_id;
        $content->title = $request->title;
        $content->content = $request->content;
        $content->content_type = $request->content_type;
        $content->step_number = CourseContent::where('course_id', $request->course_id)->max('step_number') + 1 ?? 1;

        $content->save();

        // Handle uploads (Spatie)
        if ($request->hasFile('video_file') && $request->content_type === 'video') {
            $content->addMediaFromRequest('video_file')->toMediaCollection('videos');
        }

        if ($request->hasFile('pdf_file') && $request->content_type === 'pdf') {
            $content->addMediaFromRequest('pdf_file')->toMediaCollection('pdfs');
        }

        return back()->with('success', 'Course Content Saved Successfully');
    }*/

    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|max:255',
            'content_type' => 'required|in:text,video,pdf',
            'content' => 'nullable',

            // NEW — receive tus uploaded file path
            'uploaded_video_path' => 'nullable|string',

            // PDF still normal upload
            'pdf_file' => 'nullable|mimes:pdf|max:20480',

            // multiple pdf
            'pdf_files.*' => 'nullable|mimes:pdf|max:40960',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create new content
        $content = new CourseContent();
        $content->course_id = $request->course_id;
        $content->title = $request->title;
        $content->content = $request->content;
        $content->content_type = $request->content_type;
        $content->step_number = CourseContent::where('course_id', $request->course_id)->max('step_number') + 1 ?? 1;
        $content->video_url = $request->video_url;
        $content->save();

        /**
         * =========================
         * ATTACH VIDEO (TUS + SPATIE)
         * =========================
         */

        if ($request->content_type === 'video' && $request->uploaded_video_path) {

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

            $content->addMedia($absolutePath)->toMediaCollection('videos');
        }



        /**
         * =========================
         * NORMAL PDF UPLOAD
         * =========================
         */
        if ($request->hasFile('pdf_file') && $request->content_type === 'pdf') {
            $content->addMediaFromRequest('pdf_file')->toMediaCollection('pdfs');
        }

        if ($request->hasFile('pdf_files')) {
            foreach ($request->file('pdf_files') as $file) {
                $content->addMedia($file)->toMediaCollection('pdf_files');
            }
        }

        return back()->with('success', 'Course Content Saved Successfully');
    }


    public function edit(string $id, string $course_id)
    {
        $item = CourseContent::findOrFail($id);
        return view('admin.cource_and_exams.cource-content.edit', compact('item', 'course_id'));
    }

    /*public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content_type' => 'required|in:text,video,pdf',
            'content' => 'nullable',
            'video_file' => 'nullable|mimes:mp4,mov,avi,webm|max:51200',
            'pdf_file' => 'nullable|mimes:pdf|max:20480',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $content = CourseContent::findOrFail($id);
        $content->title = $request->title;
        $content->content = $request->content;
        $content->content_type = $request->content_type;
        $content->save();

        // Replace uploaded media
        if ($request->hasFile('video_file') && $request->content_type === 'video') {
            $content->clearMediaCollection('videos');
            $content->addMediaFromRequest('video_file')->toMediaCollection('videos');
        }

        if ($request->hasFile('pdf_file') && $request->content_type === 'pdf') {
            $content->clearMediaCollection('pdfs');
            $content->addMediaFromRequest('pdf_file')->toMediaCollection('pdfs');
        }

        return back()->with('success', 'Course Content Updated Successfully');
    }*/

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content_type' => 'required|in:text,video,pdf',
            'content' => 'nullable',

            // NEW — tus upload path (instead of normal file)
            'uploaded_video_path' => 'nullable|string',

            // normal pdf
            'pdf_file' => 'nullable|mimes:pdf|max:20480',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $content = CourseContent::findOrFail($id);

        $content->title = $request->title;
        $content->content = $request->content;
        $content->content_type = $request->content_type;
        if($request->video_url){
            $content->video_url = $request->video_url;
        }
        $content->save();


        /**
         * =============================
         * UPDATE VIDEO (TUS + SPATIE)
         * =============================
         */
        if ($request->content_type === 'video' && $request->uploaded_video_path) {

            $fileId = basename($request->uploaded_video_path);

            $disk = config('tus.storage_disk', 'local');
            $dir  = trim(config('tus.storage_path', 'tus'), '/');

            $relative = "{$dir}/{$fileId}.mp4";

            if (! Storage::disk($disk)->exists($relative)) {
                return back()->with('error', "Uploaded video not found: " . Storage::disk($disk)->path($relative))
                            ->withInput();
            }

            $absolutePath = Storage::disk($disk)->path($relative);

            // remove old video
            $content->clearMediaCollection('videos');

            // attach new
            $content->addMedia($absolutePath)->toMediaCollection('videos');
        }


        /**
         * =============================
         * UPDATE PDF (Normal Upload)
         * =============================
         */
        if ($request->hasFile('pdf_file') && $request->content_type === 'pdf') {
            $content->clearMediaCollection('pdfs');
            $content->addMediaFromRequest('pdf_file')->toMediaCollection('pdfs');
        }

        if ($request->hasFile('pdf_files')) {
            foreach ($request->file('pdf_files') as $file) {
                $content->addMedia($file)->toMediaCollection('pdf_files');
            }
        }

        return back()->with('success', 'Course Content Updated Successfully');
    }


    public function destroy(string $id)
    {
        $item = CourseContent::findOrFail($id);
        $item->clearMediaCollection('videos');
        $item->clearMediaCollection('pdfs');
        $item->delete();

        return back()->with('success', 'Deleted Successfully');
    }

    public function sort(Request $request, $courseId)
    {
        foreach ($request->order as $item) {
            CourseContent::where('id', $item['id'])
                ->update(['step_number' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }

    public function deletePdf($mediaId)
    {
        $media = Media::findOrFail($mediaId);
        $media->delete();

        return back()->with('success', 'PDF deleted successfully');
    }
}
