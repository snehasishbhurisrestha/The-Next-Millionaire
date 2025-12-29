<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Exam;
use App\Models\Course;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ExamQuestionsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {       
        return [
            new Middleware('permission:Exam Questions Show', only: ['index','show']),
            new Middleware('permission:Exam Questions Create', only: ['create','store']),
            new Middleware('permission:Exam Questions Edit', only: ['edit','update']),
            new Middleware('permission:Exam Questions Delete', only: ['destroy']),
        ];
    }

    public function index(string $exam_id)
    {
        $contents = ExamQuestion::where('exam_id',$exam_id)->get();
        return view('admin.cource_and_exams.exam-questions.index',compact('contents'));
    }

    public function create(string $exam_id)
    {
        return view('admin.cource_and_exams.exam-questions.create');
    }

    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'exam_id' => 'required|exists:exams,id'
            // 'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $examQuestion = ExamQuestion::create([
                'exam_id' => $request->exam_id,
                'question' => $request->question,
                'option_a' => $request->option_a,
                'option_b' => $request->option_b,
                'option_c' => $request->option_c,
                'option_d' => $request->option_d,
                'correct_answer' => $request->correct_answer,
                'step_number' => 1,
            ]);

            if($examQuestion->id){
                return back()->with('success','Exam Question Saved Successfully');
            }else{
                return back()->with('error','Exam Question Not Saved');
            }
        }
    }

    public function show(Course $course)
    {
        //
    }

    public function edit(string $id, string $cource_id)
    {
        $item = ExamQuestion::findOrFail($id);
        return view('admin.cource_and_exams.exam-questions.edit',compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
    
        $examQuestion = ExamQuestion::findOrFail($id);
    
        $examQuestion->update([
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
        ]);

        if($examQuestion->id){
            return back()->with('success','Exam Question Updated Successfully');
        }else{
            return back()->with('error','Exam Question Not Updated');
        }
    }

    public function destroy(string $id)
    {
        $item = ExamQuestion::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }

    public function sort(Request $request, $examId)
    {
        foreach ($request->order as $item) {
            ExamQuestion::where('id', $item['id'])
                ->update(['step_number' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }

}