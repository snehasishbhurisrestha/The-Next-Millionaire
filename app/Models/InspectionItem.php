<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionItem extends Model
{
    protected $fillable = ['name', 'inspection_category_id'];

    public function category()
    {
        return $this->belongsTo(InspectionCategory::class);
    }
}
