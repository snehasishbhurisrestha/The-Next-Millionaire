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
        Schema::table('auditor_wallet_transactions', function (Blueprint $table) {
            $table->enum('transaction_type', ['credit', 'debit'])->nullable()->default('credit')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auditor_wallet_transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_type');
        });
    }
};
