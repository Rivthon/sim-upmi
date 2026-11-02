<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityIndicator extends Model
{
    use HasFactory;

    protected $fillable = ['quality_standard_id', 'name', 'unit', 'target_value', 'actual_value', 'status', 'notes'];

    public function standard()
    {
        return $this->belongsTo(QualityStandard::class, 'quality_standard_id');
    }
}
