<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Site\UserDashboard\Dashboard;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\UserDashboard\TransactionController;
use App\Http\Controllers\Site\UserDashboard\UserProfileController;

Route::middleware('auth')->group(function () {
    Route::get('user-dashboard',[Dashboard::class,'index'])->name('user-dashboard');
    Route::get('user/transaction',[TransactionController::class,'index'])->name('user.transaction');

    Route::get('/withdrawals', [TransactionController::class,'withdrawals'])
        ->name('user.withdrawals');

    Route::post('/withdraw-request', [TransactionController::class,'requestWithdraw'])
        ->name('user.withdraw.request');

    Route::get('/payment-account', [TransactionController::class,'paymentAccount'])
        ->name('user.payment.account');

    Route::post('/payment-account/update', [TransactionController::class,'updatePaymentAccount'])
        ->name('user.payment.account.update');

    Route::get('/user/profile', [UserProfileController::class,'edit'])->name('user.profile');
    Route::post('/user/profile', [UserProfileController::class,'update'])->name('user.profile.update');
});

Route::get('/r/{encoded}', [HomeController::class, 'redirectSponsor'])->name('referral.link');