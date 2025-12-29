<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Transaction owner
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Related course (nullable for withdrawals etc.)
            $table->foreignId('course_id')
                ->nullable()
                ->constrained('courses')
                ->onDelete('set null');

            // Generated from user (referral user)
            $table->foreignId('generated_from_user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            // Money fields
            $table->decimal('amount', 10, 2);

            // Transaction type
            $table->enum('type', [
                'course_purchase',
                'referral_commission',
                'wallet_add',
                'wallet_deduct',
                'withdraw_request',
                'withdraw_approved',
                'withdraw_rejected'
            ]);

            // Status
            $table->enum('status', ['pending', 'success', 'failed'])
                ->default('success');

            // Withdrawal / payment fields
            $table->string('payment_method')->nullable();   // e.g., UPI / BANK / PAYTM
            $table->string('payment_account')->nullable();  // UPI ID / Account No etc
            $table->text('admin_note')->nullable();

            $table->string('transaction_id')->nullable(); // optional gateway txn id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
