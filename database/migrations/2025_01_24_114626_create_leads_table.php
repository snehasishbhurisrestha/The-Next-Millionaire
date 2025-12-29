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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('business_name')->nullable();
            $table->unsignedBigInteger('business_category_id')->nullable();
            $table->string('email')->nullable();
            $table->enum('gender', ['male', 'female','others'])->default('male');
            $table->string('phone')->nullable();
            $table->string('opt_mobile_no')->nullable();
            $table->string('contact_person')->nullable();
            $table->text('address')->nullable();
            $table->text('business_address')->nullable();
            $table->enum('status', ['new', 'in progress', 'confirmed', 'not interested'])->default('new');
            $table->timestamps();

            $table->foreign('business_category_id')->references('id')->on('business_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
