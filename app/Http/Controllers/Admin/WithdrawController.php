<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class WithdrawController extends Controller
{
    public function index()
    {
        $withdraws = Transaction::where('type','withdraw_request')
            ->latest()
            ->paginate(20);

        return view('admin.withdraw.index', compact('withdraws'));
    }

    public function approve($id)
    {
        $withdraw = Transaction::findOrFail($id);

        if($withdraw->status == 'success')
            return back()->with('info','Already approved');

        $withdraw->status = 'success';
        $withdraw->save();

        $user = $withdraw->user;
        $user->wallet_balance -= $withdraw->amount;
        $user->save();

        return back()->with('success','Withdraw Approved Successfully');
    }

    public function reject($id)
    {
        $withdraw = Transaction::findOrFail($id);
        $withdraw->status = 'rejected';
        $withdraw->save();

        return back()->with('error','Withdraw request rejected');
    }
}
