<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Course;
use App\Models\Transaction;
use App\Models\CoursePayments;
use App\Models\Enrollment;

class RazorpayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload    = $request->getContent();
        $signature  = $request->header('X-Razorpay-Signature');
        $secret     = env('RAZORPAY_WEBHOOK_SECRET');

        // --------------------------------------------------
        // 1️⃣ VERIFY WEBHOOK SIGNATURE
        // --------------------------------------------------
        $generatedSignature = hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($generatedSignature, $signature)) {
            Log::warning('Razorpay webhook invalid signature');
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $data = json_decode($payload, true);

        // --------------------------------------------------
        // 2️⃣ HANDLE PAYMENT CAPTURE EVENT
        // --------------------------------------------------
        if ($data['event'] !== 'payment.captured') {
            return response()->json(['status' => 'ignored']);
        }

        $payment = $data['payload']['payment']['entity'];

        $paymentId = $payment['id'] ?? null;

        // --------------------------------------------------
        // 3️⃣ PREVENT DUPLICATE PROCESSING
        // --------------------------------------------------
        if (Transaction::where('transaction_id', $paymentId)->exists()) {
            return response()->json(['status' => 'already_processed']);
        }

        // --------------------------------------------------
        // 4️⃣ GET USER & COURSE FROM NOTES (IMPORTANT)
        // --------------------------------------------------
        $userId   = $payment['notes']['user_id']   ?? null;
        $courseId = $payment['notes']['course_id'] ?? null;

        if (!$userId || !$courseId) {
            Log::error('Webhook missing user_id or course_id', $payment);
            return response()->json(['error' => 'Missing metadata'], 400);
        }

        $user   = User::find($userId);
        $course = Course::find($courseId);

        if (!$user || !$course) {
            Log::error('Webhook invalid user/course', [
                'user_id' => $userId,
                'course_id' => $courseId
            ]);
            return response()->json(['error' => 'Invalid user or course'], 400);
        }

        $price = $course->offer_price > 0
            ? $course->offer_price
            : $course->price;

        // --------------------------------------------------
        // 5️⃣ ATOMIC DATABASE TRANSACTION
        // --------------------------------------------------
        DB::beginTransaction();

        try {

            // Course purchase transaction
            $transaction = Transaction::create([
                'user_id'        => $user->id,
                'course_id'      => $course->id,
                'amount'         => $price,
                'type'           => 'course_purchase',
                'status'         => 'success',
                'transaction_id'=> $paymentId
            ]);

            // --------------------------------------------------
            // 6️⃣ REFERRAL COMMISSION (SAME AS verifyPayment)
            // --------------------------------------------------
            if ($user->refered_by) {

                $refUser = User::find($user->refered_by);

                if ($refUser) {

                    $commission = get_setting('referal_bonus_amount');

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

            // --------------------------------------------------
            // 7️⃣ COURSE PAYMENT + ENROLLMENT
            // --------------------------------------------------
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

            $user->update(['status' => 1]);

            DB::commit();

            Log::info('Webhook enrollment success', [
                'payment_id' => $paymentId,
                'user_id' => $user->id,
                'course_id' => $course->id
            ]);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Webhook enrollment failed', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }
}
