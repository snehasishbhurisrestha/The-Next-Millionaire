<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\UncapturedPayment;
use App\Models\Transaction;
use App\Models\CoursePayments;
use App\Models\Enrollment;

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

        return view('admin.uncaptured_payment.index', compact('uncaptured_payments'));
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
}