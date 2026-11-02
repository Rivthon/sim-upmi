<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityStandard extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'description', 'category', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function indicators()
    {
        return $this->hasMany(QualityIndicator::class);
    }
}
