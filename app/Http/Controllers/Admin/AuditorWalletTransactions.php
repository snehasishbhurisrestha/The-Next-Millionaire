<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\AuditorWalletTransaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditorWalletTransactions extends Controller
{
    public function transactions()
    {
        $transactions = AuditorWalletTransaction::where('auditor_id',Auth::id())->orderBy('id','desc')->get();
        return view('admin.auditor_transaction.transactions',compact('transactions'));
    }
}
