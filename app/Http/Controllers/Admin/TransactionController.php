<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user','course')
            ->latest()
            ->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('user','course')->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }
}
