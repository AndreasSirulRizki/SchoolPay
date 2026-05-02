<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifs = Notifikasi::forUser('staff', auth()->id());
        Notifikasi::where('user_type', 'staff')->where('user_id', auth()->id())->update(['is_read' => true]);
        return response()->json($notifs);
    }

    public function markRead(int $id)
    {
        Notifikasi::where('id', $id)->where('user_type', 'staff')->where('user_id', auth()->id())->update(['is_read' => true]);
        return response()->json(['ok' => true]);
    }

    public function readAll()
    {
        Notifikasi::where('user_type', 'staff')->where('user_id', auth()->id())->update(['is_read' => true]);
        return response()->json(['ok' => true]);
    }
}
