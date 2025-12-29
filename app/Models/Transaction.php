<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'generated_from_user_id',
        'amount',
        'type',
        'status',
        'payment_method',
        'payment_account',
        'admin_note',
        'transaction_id',
    ];

    // Owner of transaction
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Course related to transaction
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Referral / generated user
    public function generatedFromUser()
    {
        return $this->belongsTo(User::class, 'generated_from_user_id');
    }
}
