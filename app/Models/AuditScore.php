<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditScore extends Model
{
    protected $fillable = ['audit_id', 'inspection_item_id', 'score', 'notes'];

    public function audit()
    {
        return $this->belongsTo(Audit::class);
    }

    public function inspectionItem()
    {
        return $this->belongsTo(InspectionItem::class);
    }
}
