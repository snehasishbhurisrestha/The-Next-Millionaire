<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditorWallet extends Model
{
    protected $fillable = [
        'auditor_id',
        'amount'
    ];
}
