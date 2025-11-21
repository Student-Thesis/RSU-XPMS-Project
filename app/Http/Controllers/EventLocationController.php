<?php

namespace App\Http\Controllers;

use App\Models\EventLocation;
use Illuminate\Http\Request;

class EventLocationController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $locations = EventLocation::query()
            ->when($q, function ($query, $q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('address', 'like', "%{$q}%")
                      ->orWhere('room', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('event_locations.index', compact('locations', 'q'));
    }

    public function create()
    {
        return view('event_locations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'nullable|string|max:255',
            'room'      => 'nullable|string|max:100',
            'notes'     => 'nullable|string',
            'is_active' => 'nullable',
        ]);

        // Checkbox: if present → true, else false
        $data['is_active'] = $request->has('is_active');

        EventLocation::create($data);

        return redirect()
            ->route('event-locations.index')
            ->with('success', 'Location created successfully.');
    }

    public function edit(EventLocation $eventLocation)
    {
        return view('event_locations.edit', ['location' => $eventLocation]);
    }

    public function update(Request $request, EventLocation $eventLocation)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'nullable|string|max:255',
            'room'      => 'nullable|string|max:100',
            'notes'     => 'nullable|string',
            'is_active' => 'nullable',
        ]);

        $data['is_active'] = $request->has('is_active');

        $eventLocation->update($data);

        return redirect()
            ->route('event-locations.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(EventLocation $eventLocation)
    {
        $eventLocation->delete();

        return redirect()
            ->route('event-locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}
