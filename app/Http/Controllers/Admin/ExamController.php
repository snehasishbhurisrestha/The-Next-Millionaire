<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ExamController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Exam Show', only: ['index','show']),
            new Middleware('permission:Exam Create', only: ['create','store']),
            new Middleware('permission:Exam Edit', only: ['edit','update']),
            new Middleware('permission:Exam Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $exams = Exam::all();
        return view('admin.cource_and_exams.exam.index',compact('exams'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.cource_and_exams.exam.create',compact('courses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'course_id' => 'nullable|exists:courses,id',
            'image' => 'nullable|image|max:2048',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $exam = new Exam();
            $exam->title = $request->name;
            $exam->slug = createSlug($request->name,Exam::class);
            $exam->description = $request->description;
            $exam->type = $request->type;
            $exam->price = $request->price;
            $exam->course_id = $request->course_id;
            $exam->duration_minutes = $request->duration_minutes;
            $exam->passing_percentage = $request->passing_percentage;
            $exam->is_visible = $request->is_visible;
            if ($request->hasFile('image')) {
                $exam->addMedia($request->file('image'))->toMediaCollection('exam-image');
            }

            $res = $exam->save();
            if($res){
                return back()->with('success','Exam Created Successfully');
            }else{
                return back()->with('error','Exam Not Created');
            }
        }
    }

    public function show(Exam $exam)
    {
        //
    }

    public function edit(string $id)
    {
        $item = Exam::findOrFail($id);
        $courses = Course::all();
        return view('admin.cource_and_exams.exam.edit',compact('item','courses'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'course_id' => 'nullable|exists:courses,id',
            'image' => 'nullable|image|max:2048',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $exam = Exam::findOrFail($id);
            if($exam->title != $request->name){
                $exam->slug = createSlug($request->name,Exam::class);
            }
            $exam->title = $request->name;
            $exam->description = $request->description;
            $exam->type = $request->type;
            $exam->price = $request->price;
            $exam->course_id = $request->course_id;
            $exam->duration_minutes = $request->duration_minutes;
            $exam->passing_percentage = $request->passing_percentage;
            $exam->is_visible = $request->is_visible;
            if ($request->hasFile('image')) {
                $exam->clearMediaCollection('exam-image');
                $exam->addMedia($request->file('image'))->toMediaCollection('exam-image');
            }

            $res = $exam->update();
            if($res){
                return back()->with('success','Exam Updated Successfully');
            }else{
                return back()->with('error','Exam Not Updated');
            }
        }
    }

    public function destroy(string $id)
    {
        $item = Exam::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }
}
