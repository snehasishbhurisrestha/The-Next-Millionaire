<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\BlogCategory;

class WebBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('is_visible',1)->orderBy('id','desc')->paginate(6);

        return view('site.blog',compact('blogs'));
    }

    public function blog_details(string $slug){
        $blog = Blog::where('slug',$slug)->first();
        if($blog){
            return view('site.blog_details',compact('blog'));
        }else{
            return back()->with('error','404 | Not Found');
        }
    }
}
