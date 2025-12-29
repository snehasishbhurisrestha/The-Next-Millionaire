<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    public function businessInspectionsQnAs()
    {
        return $this->hasMany(BusinessInspectionsQnA::class, 'business_categories_id');
    }

    public function inspectionCategories()
    {
        return $this->belongsToMany(InspectionCategory::class, 'business_inspections_q_n_a_s', 'business_categories_id', 'inspection_categories_id');
    }
}
