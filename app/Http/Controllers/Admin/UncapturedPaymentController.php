<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\UncapturedPayment;
use App\Models\Transaction;
use App\Models\CoursePayments;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessMail;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UncapturedPaymentController extends Controller
{
    public function index()
    {
        $uncaptured_payments = UncapturedPayment::with('user','course')
            ->latest()
            ->get();
            
        $users = User::role('User')->where('status',0)->get();
        $courses = Course::all();

        return view('admin.uncaptured_payment.index', compact('uncaptured_payments','users','courses'));
    }

    public function process_payment(Request $request)
    {
        $uncaptured_payment = UncapturedPayment::find($request->uncaptured_payment_id);
        if($uncaptured_payment){
            $alreadyExists = Transaction::where('transaction_id', $request->transaction_id)->exists();

            if ($alreadyExists) {
                return back()->with('error', 'The Transaction ID Already Exists');
            }

            $transaction = Transaction::create([
                'user_id'        => $uncaptured_payment->user->id,
                'course_id'      => $uncaptured_payment->course->id,
                'amount'         => $uncaptured_payment->amount,
                'type'           => 'course_purchase',
                'status'         => 'success',
                'transaction_id' => $request->transaction_id
            ]);

            $user   = $uncaptured_payment->user;
            $course = $uncaptured_payment->course;

            CoursePayments::updateOrCreate(
                [
                    'user_id'   => $user->id,
                    'course_id' => $course->id
                ],
                [
                    'amount' => $uncaptured_payment->amount,
                    'status' => 'paid'
                ]
            );

            Enrollment::updateOrCreate(
                ['user_id' => $user->id, 'course_id' => $course->id],
                ['status'  => 'enrolled']
            );

            $user->status = 1;
            $user->update();

            try {
                Mail::to($user->email)->send(
                    new PaymentSuccessMail($user, $course, $transaction)
                );
            } catch (\Exception $e) {
                \Log::warning('Payment email failed', ['error' => $e->getMessage()]);
            }

            $uncaptured_payment->delete();

            return back()->with('success', 'Payment Verified & Enrolled Successfully');
        }
    }
    
    public function manual_process_payment(Request $request)
    {
        
        // ================= VALIDATION =================
        $validator = Validator::make($request->all(), [
            'user_id'        => 'required|exists:users,id',
            'course_id'      => 'required|exists:courses,id',
            'amount'         => 'required|numeric|min:1',
            'transaction_id' => 'required|string|max:255|unique:transactions,transaction_id',
        ], [
            'user_id.required'        => 'User is required.',
            'user_id.exists'          => 'Selected user does not exist.',
            'course_id.required'      => 'Course is required.',
            'course_id.exists'        => 'Selected course does not exist.',
            'amount.required'         => 'Amount is required.',
            'amount.numeric'          => 'Amount must be a number.',
            'amount.min'              => 'Amount must be greater than 0.',
            'transaction_id.required' => 'Transaction ID is required.',
            'transaction_id.unique'   => 'This Transaction ID already exists.',
        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $alreadyExists = Transaction::where('transaction_id', $request->transaction_id)->exists();

        if ($alreadyExists) {
            return back()->with('error', 'The Transaction ID Already Exists');
        }

        $transaction = Transaction::create([
            'user_id'        => $request->user_id,
            'course_id'      => $request->course_id,
            'amount'         => $request->amount,
            'type'           => 'course_purchase',
            'status'         => 'success',
            'transaction_id' => $request->transaction_id
        ]);

        $user   = User::find($request->user_id);
        $course = Course::find($request->course_id);

        CoursePayments::updateOrCreate(
            [
                'user_id'   => $user->id,
                'course_id' => $course->id
            ],
            [
                'amount' => $request->amount,
                'status' => 'paid'
            ]
        );

        Enrollment::updateOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['status'  => 'enrolled']
        );

        $user->status = 1;
        $user->update();

        try {
            Mail::to($user->email)->send(
                new PaymentSuccessMail($user, $course, $transaction)
            );
        } catch (\Exception $e) {
            \Log::warning('Payment email failed', ['error' => $e->getMessage()]);
        }

        return back()->with('success', 'Payment Verified & Enrolled Successfully');
    }
}