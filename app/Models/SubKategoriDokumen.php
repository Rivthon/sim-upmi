<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubKategoriDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_dokumen_id',
        'nama',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriDokumen::class, 'kategori_dokumen_id');
    }
    public function dokumenMutus()
{
    return $this->hasMany(DokumenMutu::class, 'sub_kategori_id');
}
protected static function booted()
{
    static::saving(function ($model) {
        if (empty($model->slug)) {
            $model->slug = \Str::slug($model->nama);
        }
    });
}
public static function boot()
{
    parent::boot();

    static::saving(function ($model) {
        $model->slug = Str::slug($model->nama);
    });
}
}
