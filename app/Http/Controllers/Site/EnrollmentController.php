<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Razorpay\Api\Api;
use App\Models\Course;
use App\Models\CoursePayments;
use App\Models\Enrollment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UncapturedPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    // Enroll User (Free or Paid)
    public function enroll(Request $request, $course_id)
    {
        $user = Auth::user();
        $course = Course::findOrFail($course_id);

        // If the course is free, enroll directly
        if ($course->price == 0) {
            Enrollment::updateOrCreate(
                ['user_id' => $user->id, 'course_id' => $course->id],
                ['status' => 'enrolled']
            );

            return redirect()->route('course.learn', $course->slug)
                ->with('success', 'You have successfully enrolled in this free course.');
        }

        // For paid courses, redirect to the payment page
        return view('site.courses.payment', compact('course'));
    }

    // Process Payment
    public function processPayment(Request $request)
    {
        $user = Auth::user();
        $course = Course::findOrFail($request->course_id);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // Create an order on Razorpay
        $order = $api->order->create([
            'receipt' => 'order_' . uniqid(),
            'amount' => $course->price * 100, // Amount in paise
            'currency' => 'INR',
            'payment_capture' => 1 // Auto-capture payment
        ]);

        return response()->json([
            'order_id' => $order->id,
            'razorpay_key' => env('RAZORPAY_KEY'),
            'amount' => $course->price * 100,
            'course_id' => $course->id
        ]);
    }

    // Verify Payment
    /*public function verifyPayment(Request $request)
    {
        
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Payment successful, save in database
            $user = Auth::user();
            $course = Course::find($request->course_id);
            $price = $course->offer_price != 0 ? $course->offer_price : $course->price;

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'amount' => $price,
                'type' => 'course_purchase',
                'status' => 'success',
                'transaction_id' => $request->razorpay_payment_id
            ]);

            if ($user->refered_by) {   // make sure you have this field in users table
                $refUser = User::find($user->refered_by);

                if ($refUser) {

                    $commission = get_setting('referal_bonus_amount'); // 300

                    // Save referral transaction
                    Transaction::create([
                        'user_id' => $refUser->id,
                        'generated_from_user_id' => $user->id,
                        'course_id' => $course->id,
                        'amount' => $commission,
                        'type' => 'referral_commission',
                        'status' => 'success'
                    ]);

                    // Add money to wallet
                    $refUser->total_income += $commission;
                    $refUser->wallet_balance += $commission;
                    $refUser->save();
                }
            }


            CoursePayments::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'amount' => $price,
                'status' => 'paid'
            ]);

            Enrollment::updateOrCreate(
                ['user_id' => $user->id, 'course_id' => $course->id],
                ['status' => 'enrolled']
            );

            $user->status = 1;
            $user->update();

            // Send Email
            Mail::to($user->email)->send(new PaymentSuccessMail($user, $course, $transaction));

            // return redirect()->route('course.learn', $course->slug)
            //     ->with('success', 'Payment successful! You are now enrolled.');

            return response()->json([
                'redirect' => route('course.learn', $course->slug),
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment verification failed! Please try again.');
        }
    }*/

    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $user = Auth::user();
        $course = Course::findOrFail($request->course_id);
        $price = $course->offer_price > 0 ? $course->offer_price : $course->price;

        try {

            /*
            |-------------------------------------------------
            | 1️⃣ VERIFY SIGNATURE (FAST FAIL)
            |-------------------------------------------------
            */
            $attributes = [
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id'=> $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            /*
            |-------------------------------------------------
            | 2️⃣ DOUBLE CHECK PAYMENT STATUS (CRITICAL)
            |-------------------------------------------------
            */
            $payment = $api->payment->fetch($request->razorpay_payment_id);

            if ($payment->status !== 'captured') {

                $uncaptured_payment = new UncapturedPayment();
                $uncaptured_payment->user_id = $user->id;
                $uncaptured_payment->course_id = $course->id;
                $uncaptured_payment->amount = $price;
                $uncaptured_payment->save();

                return response()->json([
                    'success' => false,
                    'message' => 'Payment not captured yet. Please wait or contact support.'
                ], 400);
            }

            /*
            |-------------------------------------------------
            | 3️⃣ PREVENT DUPLICATE PAYMENT
            |-------------------------------------------------
            */
            $alreadyExists = Transaction::where('transaction_id', $payment->id)->exists();

            if ($alreadyExists) {
                return response()->json([
                    'redirect' => route('course.learn', $course->slug)
                ]);
            }

            /*
            |-------------------------------------------------
            | 4️⃣ DB TRANSACTION (ATOMIC)
            |-------------------------------------------------
            */
            DB::beginTransaction();

            // Course purchase transaction
            $transaction = Transaction::create([
                'user_id'        => $user->id,
                'course_id'      => $course->id,
                'amount'         => $price,
                'type'           => 'course_purchase',
                'status'         => 'success',
                'transaction_id'=> $payment->id
            ]);

            /*
            |-------------------------------------------------
            | 5️⃣ REFERRAL COMMISSION (SAFE)
            |-------------------------------------------------
            */
            if ($user->refered_by) {

                $refUser = User::find($user->refered_by);

                if ($refUser) {

                    $commission = get_setting('referal_bonus_amount'); // ex: 300

                    Transaction::create([
                        'user_id' => $refUser->id,
                        'generated_from_user_id' => $user->id,
                        'course_id' => $course->id,
                        'amount' => $commission,
                        'type' => 'referral_commission',
                        'status' => 'success'
                    ]);

                    $refUser->increment('total_income', $commission);
                    $refUser->increment('wallet_balance', $commission);
                }
            }

            /*
            |-------------------------------------------------
            | 6️⃣ COURSE PAYMENT + ENROLLMENT
            |-------------------------------------------------
            */
            CoursePayments::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $course->id
                ],
                [
                    'amount' => $price,
                    'status' => 'paid'
                ]
            );

            Enrollment::updateOrCreate(
                ['user_id' => $user->id, 'course_id' => $course->id],
                ['status' => 'enrolled']
            );

            $user->status = 1;
            $user->update();

            DB::commit();

            /*
            |-------------------------------------------------
            | 7️⃣ EMAIL (AFTER COMMIT)
            |-------------------------------------------------
            */
            try {
                Mail::to($user->email)->send(
                    new PaymentSuccessMail($user, $course, $transaction)
                );
            } catch (\Exception $e) {
                \Log::warning('Payment email failed', ['error' => $e->getMessage()]);
            }

            return response()->json([
                'redirect' => route('course.learn', $course->slug),
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            \Log::error('Razorpay payment failed', [
                'order_id' => $request->razorpay_order_id ?? null,
                'payment_id' => $request->razorpay_payment_id ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed. If amount is debited, contact support.'
            ], 500);
        }
    }

}
