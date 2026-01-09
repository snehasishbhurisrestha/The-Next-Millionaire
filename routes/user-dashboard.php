<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Site\UserDashboard\Dashboard;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\UserDashboard\TransactionController;
use App\Http\Controllers\Site\UserDashboard\UserProfileController;
use App\Http\Controllers\Site\UserDashboard\CourseReviewController;
use App\Http\Controllers\Site\UserDashboard\CommunityController;

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

    Route::post('/course/{course}/review', [CourseReviewController::class, 'store'])->name('course.review.submit');

    Route::get('/community', [CommunityController::class,'index'])->name('community');

    Route::post('/community/send',[CommunityController::class,'sendCommunity'])->name('community.send');
    Route::post('/community/edit/{id}',[CommunityController::class,'editCommunity']);

    Route::get('/community/chat/request/{id}',[CommunityController::class,'requestChat']);
    Route::post('/community/chat/{id}/status',[CommunityController::class,'updateChatStatus']);
    Route::post('/community/chat/{id}/send',[CommunityController::class,'sendPrivate']);
    Route::get('/community/members',[CommunityController::class,'get_members']);
    Route::get('/community/chat/with/{id}', [CommunityController::class, 'privateChat']);

});

Route::get('/r/{encoded}', [HomeController::class, 'redirectSponsor'])->name('referral.link');