<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventLocation extends Model
{
    // If you're NOT using UUIDs here, leave as is (auto-increment id)
    // protected $primaryKey = 'id';

    protected $fillable = ['name', 'address', 'room', 'notes', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function calendarPage()
    {
        $eventLocations = EventLocation::orderBy('name')->get();

        return view('calendar.index', compact('eventLocations'));
    }
}
