<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;

class NotificationController extends Controller
{
    public function index()
    {
        $siswa = auth('siswa')->user();
        $notifs = Notifikasi::forUser('siswa', $siswa->id);
        Notifikasi::where('user_type', 'siswa')->where('user_id', $siswa->id)->update(['is_read' => true]);
        return response()->json($notifs);
    }

    public function markRead(int $id)
    {
        $siswa = auth('siswa')->user();
        Notifikasi::where('id', $id)->where('user_type', 'siswa')->where('user_id', $siswa->id)->update(['is_read' => true]);
        return response()->json(['ok' => true]);
    }
}
