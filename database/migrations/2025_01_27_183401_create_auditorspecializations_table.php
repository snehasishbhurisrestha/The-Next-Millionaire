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
        Schema::create('auditorspecializations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auditor_id');
            $table->unsignedBigInteger('certificate_id');
            $table->timestamps();

            $table->foreign('auditor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('certificate_id')->references('id')->on('certification_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorspecializations');
    }
};
