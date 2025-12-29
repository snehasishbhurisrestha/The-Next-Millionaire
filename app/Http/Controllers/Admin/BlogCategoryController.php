<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BlogCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Blog Category Show', only: ['index','show']),
            new Middleware('permission:Blog Category Create', only: ['create','store']),
            new Middleware('permission:Blog Category Edit', only: ['edit','update']),
            new Middleware('permission:Blog Category Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $items = BlogCategory::all();
        return view('admin.blog.blog-category.index',compact('items'));
    }

    public function create()
    {
        return view('admin.blog.blog-category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = new BlogCategory();
            $item->name = $request->name;
            $item->slug = createSlug($request->name,BlogCategory::class);
            $item->is_visible = $request->is_visible;
            $res = $item->save();
            if($res){
                return back()->with('success','Added Successfully');
            }else{
                return back()->with('error','Not Added');
            }
        }
    }

    public function show(BlogCategory $blogCategory)
    {
        //
    }

    public function edit(string $id)
    {
        $item = BlogCategory::findOrFail($id);
        return view('admin.blog.blog-category.edit',compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = BlogCategory::findOrFail($id);
            if($item->name != $request->name){
                $item->slug = createSlug($request->name,BlogCategory::class);
            }
            $item->name = $request->name;
            $item->is_visible = $request->is_visible;
            $res = $item->update();
            if($res){
                return back()->with('success','Updated Successfully');
            }else{
                return back()->with('error','Not Updated');
            }
        }
    }

    public function destroy(string $id)
    {
        $item = BlogCategory::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }
}
