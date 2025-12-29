<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CertificationType;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\NewsletterEmail;
use App\Models\Course;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // $certificates = CertificationType::where('is_visible',1)->get();
        // $certificate_is_schorallable = count($certificates) > 4 ? true : false;
        // $certificates = $certificates->chunk(4);

        // $blogs = Blog::where('is_visible',1)->orderBy('id','desc')->limit(6)->get();
        if ($request->has('ref')) {
            $decodedId = base64_decode($request->get('ref'));
            // Optional: track sponsor, store session, etc.
            session(['sponsor_id' => $decodedId]);
        }
        $cource = Course::first();
        $testimonials = Testimonial::where('is_visible',1)->orderBy('created_at','desc')->get();

        return view('site.home',compact('cource','testimonials'));
    }

    public function redirectSponsor($encoded)
    {
        // Decode the hidden sponsor ID
        $decodedId = base64_decode($encoded);

        // Redirect to home with decoded sponsor id (invisible to user)
        return redirect()->route('home', ['ref' => $encoded]);
    }

    public function newsletter_subscribe(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $NewsletterEmail = new NewsletterEmail();
        $NewsletterEmail->email = $request->email;
        $NewsletterEmail->save();

        return response()->json(['message' => 'Subscription successful']);
    }
}

