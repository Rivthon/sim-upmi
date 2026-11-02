<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'url',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public static function notifyAdmins(string $title, ?string $message = null, ?string $url = null): void
    {
        User::role(['admin-upmi', 'super-admin'])->get()->each(function (User $user) use ($title, $message, $url) {
            self::create([
                'user_id' => $user->id,
                'title' => $title,
                'message' => $message,
                'url' => $url,
            ]);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
