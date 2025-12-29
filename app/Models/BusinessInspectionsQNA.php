<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessInspectionsQNA extends Model
{
    protected $fillable = ['business_categories_id', 'inspection_categories_id'];

    // Relationship with BusinessCategory
    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_categories_id');
    }

    // Relationship with InspectionCategory
    public function inspectionCategory()
    {
        return $this->belongsTo(InspectionCategory::class, 'inspection_categories_id');
    }
}
