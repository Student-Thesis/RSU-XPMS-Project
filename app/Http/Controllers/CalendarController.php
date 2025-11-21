<?php

namespace App\Http\Controllers;

use App\Models\EventLocation;

class CalendarController extends Controller
{
    public function index()
    {
        $eventLocations = EventLocation::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('calendar.index', compact('eventLocations'));
    }
}
