<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Testimonial;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use Illuminate\Support\Facades\Validator;

class TestimonialVideoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Testimonial2 Show', only: ['index']),
            new Middleware('permission:Testimonial2 Create', only: ['create','store']),
            new Middleware('permission:Testimonial2 Edit', only: ['edit','update']),
            new Middleware('permission:Testimonial2 Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $testimonials = Testimonial::whereIn('type',['video','screenshort'])->get();
        return view('admin.testimonial2.index',compact('testimonials'));
    }

    // public function create()
    // {
    //     return view('admin.testimonial2.create');
    // }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_visible' => 'required|in:0,1'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $testimonial = new Testimonial();
        $testimonial->is_visible = $request->is_visible;
        if($request->type == 'video'){
            $testimonial->type = 'video';
            $testimonial->video_url = $request->video_url;
        }
        if($request->type == 'screenshort'){
            $testimonial->type = 'screenshort';
            if ($request->hasFile('image')) {
                $testimonial->addMedia($request->file('image'))->toMediaCollection('testimonialss');
            }
        }
        $res = $testimonial->save();
        if($res){
            return redirect()->back()->with('success','Testimonial Created Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Added, try again!');
        }
    }

    public function show(string $id)
    {
        //
    }

    // public function edit(string $id)
    // {
    //     $testimonial = Testimonial::findOrFail($id);
    //     return view('admin.testimonial.edit',compact('testimonial'));
    // }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_visible' => 'required|in:0,1'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $testimonial = Testimonial::findOrFail($id);
        if($request->type == 'video'){
            $testimonial->type = 'video';
            $testimonial->video_url = $request->video_url;
        }
        if($request->type == 'screenshort'){
            $testimonial->type = 'screenshort';
            if ($request->hasFile('image')) {
                $testimonial->clearMediaCollection('testimonialss');
                $testimonial->addMedia($request->file('image'))->toMediaCollection('testimonialss');
            }
        }
        $testimonial->is_visible = $request->is_visible;
        $res = $testimonial->update();
        if($res){
            return redirect()->back()->with('success','Testimonial Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Updated, try again!');
        }
    }

    public function destroy(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if($testimonial){
            $res = $testimonial->delete();
            if($res){
                return back()->with('success','testimonial Deleted Successfully');
            }else{
                return back()->with('error','Not Deleted');
            }
        }else{
            return back()->with('error','Not Found');
        }
    }
}
