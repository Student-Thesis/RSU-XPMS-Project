<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class NotificationController extends Controller
{
    public function index()
    {
        // Initial load (first 5)
        $notifications = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function load(Request $request)
    {
        $offset = (int) $request->get('offset', 0);

        $notifications = ActivityLog::with('user')
            ->latest()
            ->skip($offset)
            ->take(5)
            ->get();

        return response()->json($notifications);
    }

     public function markAsRead(Request $request)
    {
        $userId = auth()->id();

        if (!$userId) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        ActivityLog::where('notifiable_user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['status' => 'ok']);
    }
}
