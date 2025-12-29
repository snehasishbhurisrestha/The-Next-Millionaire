<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Setting extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'app_name',
        'site_title',
        'coupon_offer_text',
        'maintenance_mode_text',
        'maintenance_mode',
        'razorpay_key',
        'razorpay_secret',
        'company_name',
        'raz_colour_code',
        'contact_phone_1',
        'contact_phone_2',
        'email_1',
        'email_2',
        'address_1',
        'address_2',
        'google_map_iframe',
        'facebook_link',
        'twitter_link',
        'youtube_link',
        'linkedin_link',
        'header_script',
        'footer_script',
        'referal_bonus_amount',
    ];
}
