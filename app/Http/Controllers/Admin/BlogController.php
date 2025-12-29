<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BlogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Blog Show', only: ['index','show']),
            new Middleware('permission:Blog Create', only: ['create','store']),
            new Middleware('permission:Blog Edit', only: ['edit','update']),
            new Middleware('permission:Blog Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $items = Blog::all();
        return view('admin.blog.blogs.index',compact('items'));
    }

    public function create()
    {
        $blog_caregories = BlogCategory::where('is_visible',1)->get();
        return view('admin.blog.blogs.create',compact('blog_caregories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'blog_category' => 'required|exists:blog_categories,id',
            'description' => 'required',
            'sort_description' => 'required',
            'image' => 'nullable|image|max:2048',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = new Blog();
            $item->title = $request->name;
            $item->slug = createSlug($request->name,Blog::class);
            $item->blog_category_id = $request->blog_category;
            $item->sort_description = $request->sort_description;
            $item->description = $request->description;
            $item->is_visible = $request->is_visible;
            if ($request->hasFile('image')) {
                $item->addMedia($request->file('image'))->toMediaCollection('blog-image');
            }

            $res = $item->save();
            if($res){
                return back()->with('success','Blog Added Successfully');
            }else{
                return back()->with('error','Blog Not Added');
            }
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $blog_caregories = BlogCategory::where('is_visible',1)->get();
        $item = Blog::findOrFail($id);
        return view('admin.blog.blogs.edit',compact('item','blog_caregories'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'blog_category' => 'required|exists:blog_categories,id',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = Blog::findOrFail($id);
            if($item->title != $request->name){
                $item->slug = createSlug($request->name,Blog::class);
            }
            $item->title = $request->name;
            $item->blog_category_id = $request->blog_category;
            $item->sort_description = $request->sort_description;
            $item->description = $request->description;
            $item->is_visible = $request->is_visible;
            if ($request->hasFile('image')) {
                $item->clearMediaCollection('blog-image');
                $item->addMedia($request->file('image'))->toMediaCollection('blog-image');
            }

            $res = $item->save();
            if($res){
                return back()->with('success','Blog Updated Successfully');
            }else{
                return back()->with('error','Blog Not Updated');
            }
        }
    }

    public function destroy(string $id)
    {
        $item = Blog::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }
}
