<?php

namespace App\Http\Controllers\Requestor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // ── Full notifications page ──────────────────────────────────
    public function index()
    {
        $user_id = session('user_id');

        Notification::where('user_id', $user_id)->update(['is_read' => true]);

        $notifications = Notification::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $unread_count = 0;

        return view('requestor.notifications', compact('notifications', 'unread_count'));
    }

    // ── AJAX: fetch notifications for bell dropdown ───────────────
    public function fetch()
    {
        $user_id = session('user_id');

        $notifications = Notification::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(fn($n) => [
                'id'         => $n->id,
                'title'      => $n->title,
                'message'    => $n->message,
                'type'       => $n->type,
                'is_read'    => (bool) $n->is_read,
                'request_id' => $n->request_id ?? null,
                'created_at' => $n->created_at,
            ]);

        $unread_count = Notification::where('user_id', $user_id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unread_count,
        ]);
    }

    // ── AJAX: mark as read ────────────────────────────────────────
    public function markRead(Request $request)
    {
        $user_id = session('user_id');

        if ($request->input('all')) {
            Notification::where('user_id', $user_id)->update(['is_read' => true]);
        } elseif ($id = $request->input('id')) {
            Notification::where('id', $id)->where('user_id', $user_id)->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }
}