<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certificationType()
    {
        return $this->belongsTo(CertificationType::class);
    }

    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id', 'id');
    }

    public function scores()
    {
        return $this->hasMany(AuditScore::class);
    }

    public function userBusinesses()
    {
        return $this->hasMany(UserBusiness::class, 'user_id', 'user_id');
    }

    public function inspectionCategories()
    {
        // return $this->userBusinesses()
        //     ->with('category.inspectionCategories')
        //     ->get()
        //     ->flatMap(fn($business) => $business->category->inspectionCategories);
        return $this->userBusinesses()
                    ->with('category.inspectionCategories.inspectionItems') // Include inspection items
                    ->get()
                    ->flatMap(function ($business) {
                        return $business->category->inspectionCategories->map(function ($category) {
                            return [
                                'category' => $category, // Full inspection category data
                                'items' => $category->inspectionItems, // Full inspection items data
                            ];
                        });
                    });


    }
}
