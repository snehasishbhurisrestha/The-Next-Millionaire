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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
           // Basic Info
            $table->string('app_name')->nullable();
            $table->string('site_title')->nullable();

            // Offers & Maintenance
            $table->text('coupon_offer_text')->nullable();
            $table->text('maintenance_mode_text')->nullable();
            $table->boolean('maintenance_mode')->default(false);

            // Payment Gateway
            $table->string('razorpay_key')->nullable();
            $table->string('razorpay_secret')->nullable();
            $table->string('company_name')->nullable();
            $table->string('raz_colour_code')->nullable();

            // Contact Info
            $table->string('contact_phone_1')->nullable();
            $table->string('contact_phone_2')->nullable();
            $table->string('email_1')->nullable();
            $table->string('email_2')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->longText('google_map_iframe')->nullable();

            // Social Links
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('linkedin_link')->nullable();

            // Scripts
            $table->longText('header_script')->nullable();
            $table->longText('footer_script')->nullable();

            $table->decimal('referal_bonus_amount',10,2)->default(0.00);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
