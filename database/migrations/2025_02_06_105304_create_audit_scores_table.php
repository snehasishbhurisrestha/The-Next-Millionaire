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
        Schema::create('audit_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audit_id');
            $table->unsignedBigInteger('inspection_item_id');
            $table->integer('score'); // 0, 1, or 2
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('audit_id')->references('id')->on('audits')->onDelete('cascade');
            $table->foreign('inspection_item_id')->references('id')->on('inspection_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_scores');
    }
};
