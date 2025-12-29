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
        Schema::table('course_contents', function (Blueprint $table) {
            // Add 'content' column if it doesn't exist
            $table->longText('content')->nullable()->change();

            // Add 'content_type' column if it doesn't exist
            if (!Schema::hasColumn('course_contents', 'content_type')) {
                $table->enum('content_type', ['text', 'video', 'pdf'])
                      ->default('text')
                      ->after('content');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_contents', function (Blueprint $table) {
            $table->dropColumn(['content_type']);
        });
    }
};
