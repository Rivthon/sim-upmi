<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Survey extends Model
{
    protected $fillable = [
        'judul',
        'target',
        'deskripsi',
        'is_aktif',
        'is_public',
        'public_token',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'target' => 'array',
        'is_aktif' => 'boolean',
        'is_public' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Survey $survey) {
            $survey->public_token ??= (string) Str::uuid();
        });
    }

    public function isOpenForPublic(): bool
    {
        return $this->is_public && $this->isWithinSchedule();
    }

    public function isWithinSchedule(): bool
    {
        $now = now();

        return $this->is_aktif
            && (! $this->starts_at || $now->gte($this->starts_at))
            && (! $this->ends_at || $now->lte($this->ends_at));
    }

    public function publicStatus(): string
    {
        if (! $this->is_aktif || ! $this->is_public) {
            return 'nonaktif';
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return 'terjadwal';
        }

        if ($this->ends_at && now()->gt($this->ends_at)) {
            return 'berakhir';
        }

        return 'aktif';
    }

public function questions()
{
    return $this->hasMany(SurveyQuestion::class);
}


public function targets()
{
    return $this->hasMany(SurveyTarget::class);
}
public function responses()
{
    return $this->hasMany(SurveyResponse::class);
}
}
