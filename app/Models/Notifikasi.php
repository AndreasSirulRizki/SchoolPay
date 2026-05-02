<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_type', 'user_id', 'message', 'type', 'is_read'];
    protected $casts = ['is_read' => 'boolean'];

    public static function kirim(string $userType, int $userId, string $message, string $type = 'info'): void
    {
        static::create([
            'user_type' => $userType,
            'user_id'   => $userId,
            'message'   => $message,
            'type'      => $type,
        ]);
    }

    public static function unreadCount(string $userType, int $userId): int
    {
        return static::where('user_type', $userType)->where('user_id', $userId)->where('is_read', false)->count();
    }

    public static function forUser(string $userType, int $userId, int $limit = 10)
    {
        return static::where('user_type', $userType)->where('user_id', $userId)->latest()->limit($limit)->get();
    }
}
