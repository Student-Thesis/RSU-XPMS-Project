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
}
