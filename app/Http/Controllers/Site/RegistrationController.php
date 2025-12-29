<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Course;
use App\Models\BusinessCategory;

use Razorpay\Api\Api;
use App\Mail\EmailOtpMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;

class RegistrationController extends Controller
{
    public function registration(){
        $business_categorys = BusinessCategory::where('is_visible',1)->get();
        return view('site.registration',compact('business_categorys'));
    }


    public function register_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits:10|regex:/^[6789]/',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $existing = User::where('email',$request->email)->first();
        $course   = Course::first();

        # =====================================================
        # USER ALREADY EXISTS
        # =====================================================
        if($existing){

            # not verified → send OTP again
            if(!$existing->email_verified_at){

                $otp = rand(100000,999999);
                $existing->email_otp = $otp;
                $existing->otp_expires_at = Carbon::now()->addMinutes(10);
                $existing->save();

                Mail::to($existing->email)->send(new EmailOtpMail($otp));

                Auth::login($existing);

                return response()->json([
                    'status'=>'otp_required',
                    'message'=>'OTP sent again. Please verify.',
                    'redirect'=>route('verify.otp.page')
                ]);
            }

            # verified → check enrollment
            $isEnrolled = DB::table('enrollments')
                ->where('user_id',$existing->id)
                ->where('course_id',$course->id)
                ->exists();

            if($isEnrolled){
                Auth::login($existing);

                return response()->json([
                    'status'=>'enrolled',
                    'message'=>'Already purchased',
                    'redirect'=>route('dashboard')
                ]);
            }

            # verified but not purchased → payment
            Auth::login($existing);

            return response()->json([
                'status'=>'payment_required',
                'redirect'=>route('init.payment')
            ]);
        }

        # =====================================================
        # NEW USER REGISTRATION
        # =====================================================

        $sponsor_id = session('sponsor_id') ?? null;
        // return $sponsor_id;
        if($sponsor_id){
            $sponsor_user = User::where('user_id',$sponsor_id)->first();
        }else{
            $sponsor_user = null;
        }

        $user = new User();
        $user->user_id = generateUniqueId('user');
        $user->refered_by = $sponsor_user ? $sponsor_user->id : null;
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->name       = $request->first_name.' '.$request->last_name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;
        $user->password   = bcrypt($request->password);
        $user->gender     = 'others';
        $user->status     = 0;

        // OTP
        $otp = rand(100000,999999);
        $user->email_otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        $user->syncRoles('User');

        Mail::to($user->email)->send(new EmailOtpMail($otp));

        Auth::login($user);

        return response()->json([
            'status'=>'otp_required',
            'message'=>'Registered! OTP sent to email.',
            'redirect'=>route('verify.otp.page')
        ]);
    }


    # =====================================================
    # OTP VERIFY
    # =====================================================

    public function verifyOtpPage()
    {
        return view('site.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = Auth::user();

        if (!$user) {
            return back()->with('error','Login first');
        }

        if ($user->email_otp != $request->otp) {
            return back()->with('error','Invalid OTP');
        }

        if ($user->otp_expires_at < now()) {
            return back()->with('error','OTP expired');
        }

        $user->email_verified_at = now();
        $user->email_otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('init.payment')
            ->with('success','Email Verified Successfully! Continue payment.');
    }


    # =====================================================
    # PAYMENT AFTER VERIFIED
    # =====================================================
    public function initPayment()
    {
        $user = Auth::user();
        if(!$user){
            return redirect()->route('registration');
        }

        if(!$user->email_verified_at){
            return redirect()->route('verify.otp.page')
                ->with('error','Verify email first.');
        }

        $course = Course::first();

        $isEnrolled = DB::table('enrollments')
            ->where('user_id',$user->id)
            ->where('course_id',$course->id)
            ->exists();

        if($isEnrolled){
            return redirect()->route('dashboard');
        }

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $price = $course->offer_price != 0 ? $course->offer_price : $course->price;

        $order = $api->order->create([
            'receipt' => 'order_'.$user->id,
            'amount' => $price * 100,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        // return response()->json([
        //     'user'=>$user,
        //     'course_id'=>$course->id,
        //     'order_id'=>$order['id'],
        //     'amount'=>$price * 100,
        //     'currency'=>'INR',
        //     'razorpay_key'=>env('RAZORPAY_KEY')
        // ]);

        return view('site.payment', [
            'user' => $user,
            'course_id' => $course->id,
            'order_id' => $order['id'],
            'amount' => $price * 100,
            'currency' => 'INR',
            'razorpay_key' => env('RAZORPAY_KEY')
        ]);
    }
}
