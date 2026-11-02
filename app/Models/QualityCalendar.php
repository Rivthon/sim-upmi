<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityCalendar extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category', 'start_date', 'end_date', 'location', 'description', 'status', 'created_by'];

    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];
}
