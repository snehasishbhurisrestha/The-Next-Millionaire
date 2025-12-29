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
        Schema::create('auditor_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auditor_id');
            $table->unsignedBigInteger('audit_id');
            $table->decimal('amount',10,2)->default(0.00);
            $table->timestamps();

            $table->foreign('auditor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('audit_id')->references('id')->on('audits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditor_wallet_transactions');
    }
};
