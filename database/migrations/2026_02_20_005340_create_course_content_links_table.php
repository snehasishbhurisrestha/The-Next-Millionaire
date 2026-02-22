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
        Schema::create('course_content_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_contents_id');
            $table->longText('link')->nullable();
            $table->timestamps();

            $table->foreign('course_contents_id')->references('id')->on('course_contents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_content_links');
    }
};
