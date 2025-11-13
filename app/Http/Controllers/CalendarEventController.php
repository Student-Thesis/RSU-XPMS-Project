<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CalendarEventController extends Controller
{
    /**
     * Return events for FullCalendar.
     * - show ALL public events
     * - show MY private events
     *
     * We EXPAND multi-day ranges into ONE EVENT PER DAY
     * so the same event appears on every date in the range.
     */
    public function index()
    {
        $userId = Auth::id();

        $events = CalendarEvent::query()
            ->where('visibility', 'public')
            ->orWhere(function ($q) use ($userId) {
                $q->where('visibility', 'private')
                    ->where('created_by', $userId);
            })
            ->get();

        $mapped = [];

        foreach ($events as $event) {
            $rangeStart = $event->start_date;                      // Carbon
            $rangeEnd   = $event->end_date ?? $event->start_date;  // inclusive

            // safety
            if ($rangeEnd->lt($rangeStart)) {
                $rangeEnd = $rangeStart->copy();
            }

            // color is always derived from priority
            $color = $this->priorityColor($event->priority);

            // create one event per day in the range [start, end]
            for ($date = $rangeStart->copy(); $date->lte($rangeEnd); $date->addDay()) {
                $mapped[] = [
                    // id is STILL the same DB id; FullCalendar allows duplicates
                    'id'     => $event->id,
                    'title'  => $event->title,
                    'start'  => $date->toDateString(), // that specific day
                    // one-day allDay event, no need to send end
                    'allDay' => true,
                    'color'  => $color,
                    'extendedProps' => [
                        'description' => $event->description,
                        'type'        => $event->type,
                        'location'    => $event->location,   // NEW
                        'priority'    => $event->priority,
                        'visibility'  => $event->visibility,
                        'created_by'  => $event->created_by,

                        // full original range (inclusive)
                        'range_start' => $rangeStart->toDateString(),
                        'range_end'   => $rangeEnd->toDateString(),
                    ],
                ];
            }
        }

        return $mapped;
        // or: return response()->json($mapped);
    }

    /**
     * Show single event (only owner)
     */
    public function show(CalendarEvent $event)
    {
        $this->authorizeOwner($event);
        return response()->json($event);
    }

    /**
     * Create event
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'type'        => 'nullable|string|max:100',
            'location'    => 'nullable|string|max:255',            // NEW
            'priority'    => 'nullable|in:Low,Medium,High',
            'visibility'  => 'nullable|in:public,private',
            // color is NOT accepted from front-end anymore
        ]);

        $validated['visibility'] = $validated['visibility'] ?? 'public';

        // default priority if nothing sent
        $priority = $validated['priority'] ?? 'Medium';
        $validated['priority'] = $priority;

        // derive color from priority
        $validated['color'] = $this->priorityColor($priority);

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $event = CalendarEvent::create($validated);

        $this->logActivity('Created Calendar Event', [
            'event' => $event->toArray(),
        ]);

        return response()->json([
            'message' => 'Event created.',
            'id'      => $event->id,
        ], 201);
    }

    /**
     * Update event (only owner)
     */
    public function update(Request $request, CalendarEvent $event)
    {
        $this->authorizeOwner($event);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'type'        => 'nullable|string|max:100',
            'location'    => 'nullable|string|max:255',            // NEW
            'priority' => 'nullable|in:Low,Medium,High,Critical',
            'visibility'  => 'nullable|in:public,private',
        ]);

        // keep old priority if not sent (just in case)
        $priority = $validated['priority'] ?? $event->priority ?? 'Medium';
        $validated['priority'] = $priority;

        // derive color again from priority
        $validated['color'] = $this->priorityColor($priority);

        if (!isset($validated['visibility'])) {
            $validated['visibility'] = $event->visibility ?? 'public';
        }

        $old = $event->toArray();

        $validated['updated_by'] = Auth::id();
        $event->update($validated);

        $this->logActivity('Updated Calendar Event', [
            'old' => $old,
            'new' => $event->fresh()->toArray(),
        ]);

        return response()->json(['message' => 'Event updated.']);
    }

    /**
     * Delete event (only owner)
     */
    public function destroy(CalendarEvent $event)
    {
        $this->authorizeOwner($event);

        $eventData = $event->toArray();
        $event->delete();

        $this->logActivity('Deleted Calendar Event', [
            'event' => $eventData,
        ]);

        return response()->json(['message' => 'Event deleted.']);
    }

    /**
     * Only creator can edit/delete
     */
    protected function authorizeOwner(CalendarEvent $event): void
    {
        if ($event->created_by !== Auth::id()) {
            abort(403, 'You do not own this event.');
        }
    }

    /**
     * Map priority -> color
     * Low    = green
     * Medium = yellow
     * High   = red
     */
    private function priorityColor(?string $priority): string
    {
        $priority = $priority ?? 'Medium';

        return match ($priority) {
            'Critical' => '#8B0000', // dark red
            'High'   => '#dc3545', // red
            'Medium' => '#ffc107', // yellow
            'Low'    => '#28a745', // green
            default  => '#6c757d', // grey fallback
        };
    }

    /**
     * Local logging method
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id'                 => Str::uuid(),
            'user_id'            => Auth::id(),
            'notifiable_user_id' => Auth::id(),
            'action'             => $action,
            'model_type'         => CalendarEvent::class,
            'model_id'           => $changes['event']['id'] ?? $changes['new']['id'] ?? null,
            'changes'            => $changes,
            'ip_address'         => request()->ip(),
            'user_agent'         => request()->userAgent(),
        ]);
    }
}
