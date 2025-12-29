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
        Schema::create('business_inspections_q_n_a_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_categories_id');
            $table->unsignedBigInteger('inspection_categories_id');
            $table->timestamps();

            $table->foreign('business_categories_id')->references('id')->on('business_categories')->onDelete('cascade');
            $table->foreign('inspection_categories_id')->references('id')->on('inspection_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_inspections_q_n_a_s');
    }
};
