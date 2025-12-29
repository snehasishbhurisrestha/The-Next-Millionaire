<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBusiness extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'business_category_id',
        'trade_license_number',
        'business_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id', 'id');
    }

}
