<?php

namespace App\Http\Controllers\Site\UserDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\BusinessCategory;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(){

        $user = auth()->user();
        $referrals = Transaction::where('user_id', $user->id)
            ->where('type', 'referral_commission')
            ->orderBy('id', 'desc')
            ->get();

        return view('site.user-dashboard.transaction', compact('referrals'));
    }

    public function paymentAccount()
    {
        return view('site.user-dashboard.payment-account');
    }

    public function updatePaymentAccount(Request $request)
    {
        $user = auth()->user();

        if($request->confirm_account_number != $request->account_number){
            return back()->with('error','Confirm account number not match');
        }

        $user->update([
            'upi_id' => $request->upi_id,
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
        ]);

        return back()->with('success','Payment account updated successfully');
    }

    public function withdrawals()
    {
        $user = auth()->user();

        $withdrawals = Transaction::where('user_id', $user->id)
            ->whereIn('type', [
                'withdraw_request',
                'withdraw_approved',
                'withdraw_rejected'
            ])
            ->orderBy('id','desc')
            ->get();

        return view('site.user-dashboard.withdrawals', compact('withdrawals'));
    }

    public function requestWithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $user = auth()->user();

        $hasUPI  = !empty($user->upi_id);
        $hasBank = !empty($user->bank_name) &&
                !empty($user->account_number) &&
                !empty($user->ifsc_code);

        if (!$hasUPI && !$hasBank) {
            return back()->with('error', 'Please update your payment account (UPI or Bank) before requesting withdrawal.');
        }

        if ($request->amount > $user->wallet_balance)
            return back()->with('error', 'Insufficient wallet balance');

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => 'withdraw_request',
            'status' => 'pending',
            'payment_method' => $user->upi_id ? 'upi' : 'bank',
            'payment_account' =>
                $user->upi_id ??
                ($user->bank_name.' | '.$user->account_number.' | '.$user->ifsc_code),
        ]);

        return back()->with('success', 'Withdrawal request submitted');
    }

}