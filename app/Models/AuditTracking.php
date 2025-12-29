<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTracking extends Model
{
    protected $fillable = [
        'audit_id',
        'description',
    ];
}
