<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagementReview extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'meeting_date', 'location', 'agenda', 'participants', 'notes', 'decisions', 'status', 'created_by'];

    protected $casts = ['meeting_date' => 'date'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function capas()
    {
        return $this->hasMany(Capa::class);
    }
}
