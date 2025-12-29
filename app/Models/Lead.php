<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'business_name',
        'business_category_id',
        'email',
        'gender',
        'phone',
        'opt_mobile_no',
        'contact_person',
        'address',
        'business_address',
        'status',
    ];
    
    public function category()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id', 'id');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }

    public function latestFollowUp()
    {
        return $this->hasOne(FollowUp::class)->latestOfMany();
    }
}
