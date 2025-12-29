<?php

namespace App\Http\Controllers\Site\UserDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\BusinessCategory;
use App\Models\Lead;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index(){
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        if($user->status !=1 ){
            return redirect()->back()->with('Please Purchase the course first');
        }

        // Encode sponsor ID securely
        $encoded = base64_encode($user->user_id);

        // Create final hidden referral link
        $shareUrl = route('referral.link', ['encoded' => $encoded]);

        $userId = $user->id;

        // Total referrals (users who came via this user's link)
        $totalReferrals = User::where('refered_by',$userId)->count();

        // Total income generated from referrals
        $totalIncome = $user->total_income;

        // Total withdrawals

        $totalWithdraw = Transaction::where('user_id', $userId)
                                    ->where('type', 'withdraw_request')
                                    ->where('status', 'success')
                                    ->sum('amount');

        // Current balance
        $balance = $totalIncome - $totalWithdraw;

        return view('site.user-dashboard.dashboard', compact('shareUrl','totalReferrals','totalIncome','totalWithdraw', 'balance'));
    }
}