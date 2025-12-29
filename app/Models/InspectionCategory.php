<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionCategory extends Model
{
    protected $fillable = ['name', 'max_score'];

    public function inspectionItems()
    {
        return $this->hasMany(InspectionItem::class);
    }

    public function businessInspectionsQnAs()
    {
        return $this->hasMany(BusinessInspectionsQnA::class, 'inspection_categories_id');
    }

    public function businessCategories()
    {
        return $this->belongsToMany(BusinessCategory::class, 'business_inspections_q_n_a_s', 'inspection_categories_id', 'business_categories_id');
    }
}
