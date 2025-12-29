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
        Schema::create('audit_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audit_id');
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->tinyInteger('is_approved')->default(0);
            $table->tinyInteger('is_visible')->default(0);
            $table->timestamps();

            $table->foreign('audit_id')->references('id')->on('audits')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_reports');
    }
};
