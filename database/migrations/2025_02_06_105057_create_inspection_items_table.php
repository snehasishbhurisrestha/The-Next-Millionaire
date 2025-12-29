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
        Schema::create('inspection_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspection_category_id');
            $table->string('name');
            $table->integer('point')->default(0); // 0, 1, or 2
            $table->tinyInteger('is_visible')->default(0);
            $table->timestamps();

            $table->foreign('inspection_category_id')->references('id')->on('inspection_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_items');
    }
};
