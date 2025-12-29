<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\BusinessCategory;
use App\Models\UserBusiness;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;

use App\Mail\EmailOtpMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

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
            'business_name' => 'nullable|max:255',
            'business_category' => 'nullable|exists:business_categories,id',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|regex:/^[6789]/|unique:users,phone',
            'opt_mobile_no' => 'nullable|digits:10|regex:/^[6789]/',
            'gender' => 'nullable|in:male,female,others',
            'trade_license_number' => 'nullable',
            'password' => 'required|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'trade_license_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'nullable|in:1,0'
        ], [
            'profile_image.max' => 'The Profile Image must not be larger than 2 MB.',
            'trade_license_image.max' => 'The Trade License Image must not be larger than 2 MB.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }else{
            $sponsor_id = session('sponsor_id') ?? null;
            // return $sponsor_id;
            if($sponsor_id){
                $sponsor_user = User::where('user_id',$sponsor_id)->first();
            }else{
                $sponsor_user = null;
            }
            // return $user->id;
            $user = new User();
            $user->user_id = generateUniqueId('user');
            $user->refered_by = $sponsor_user ? $sponsor_user->id : null;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->name = $request->first_name.' '.$request->last_name;
            $user->status = $request->status ?? 0;
            // $user->date_of_birth = format_date_for_db($request->date_of_birth);
            $user->gender = $request->gender ?? 'others';
            // $user->address = $request->address;
            $user->email = $request->email;
            $user->phone = $request->phone;
            // $user->opt_mobile_no = $request->opt_mobile_no;
            $user->password = bcrypt($request->password);

            // Generate OTP
            $otp = rand(100000,999999);
            $user->email_otp = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(10);

            $res = $user->save();

            // if ($request->hasFile('profile_image')) {
            //     $user->addMedia($request->file('profile_image'))->toMediaCollection('user-image');
            // }

            // if ($request->hasFile('trade_license_image')) {
            //     $user->addMedia($request->file('trade_license_image'))->toMediaCollection('user-trade-licence');
            // }

            $user->syncRoles('User');

            // Send OTP Mail
            Mail::to($user->email)->send(new EmailOtpMail($otp));

            // $user_business = UserBusiness::create([
            //     'user_id' => $user->id,
            //     'business_name' => $request->business_name,
            //     'business_category_id' => $request->business_category,
            //     'trade_license_number' => $request->trade_license_number,
            //     'business_address' => $request->business_address
            // ]);

            // event(new Registered($user));

            Auth::login($user);

            // return redirect(route('dashboard', absolute: false))->with('success','Registered Successfully');

            // if($res){
            //     return back()->with('success','Registered Successfully');
            // }else{
            //     return back()->with('success','Not Registered');
            // }

            // Razorpay API
            // Razorpay API
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $cource = Course::first();
            $price = $cource->offer_price != 0 ? $cource->offer_price : $cource->price;
            $orderData = [
                'receipt' => 'order_'.$user->id,
                'amount' => $price * 100, // ₹1000 in paise
                'currency' => 'INR',
                'payment_capture' => 1
            ];

            $razorpayOrder = $api->order->create($orderData);
            return response()->json([
                'user' => $user,
                'cource_id' => $cource->id,
                'order_id' => $razorpayOrder['id'],
                'amount' => $orderData['amount'],
                'currency' => $orderData['currency'],
                'razorpay_key' => env('RAZORPAY_KEY')
            ]);
        }
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

        // Mark Verified
        $user->email_verified_at = now();
        $user->email_otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('dashboard')->with('success','Email Verified Successfully!');
    }

}
