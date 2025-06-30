<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'narasi', 'gambar'];
    protected static function booted()
{
    static::creating(function ($berita) {
        $berita->slug = \Str::slug($berita->judul) . '-' . uniqid();
    });

    static::updating(function ($berita) {
        $berita->slug = \Str::slug($berita->judul) . '-' . uniqid();
    });
}

}
