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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('certification_type_id');
            $table->date('audit_date');
            $table->unsignedBigInteger('auditor_id')->nullable();
            $table->enum('status', ['Placed', 'Approved','Auditor Assigned','Visit Complete','Report Uploaded','Complete','Cancelled'])->nullable()->default('Placed');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('certification_type_id')->references('id')->on('certification_types')->onDelete('cascade');
            $table->foreign('auditor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
