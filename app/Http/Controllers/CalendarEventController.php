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
     * Return events for FullCalendar (JSON).
     * - show ALL public events
     * - show MY private events
     * - expand multi-day ranges into one event per day
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
                    'id'     => $event->id,
                    'title'  => $event->title,
                    'start'  => $date->toDateString(),
                    'allDay' => true,
                    'color'  => $color,
                    'extendedProps' => [
                        'description' => $event->description,
                        'type'        => $event->type,
                        'location'    => $event->location,
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

        return response()->json($mapped);
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
            'location'    => 'nullable|string|max:255',
            'priority'    => 'nullable|in:Low,Medium,High,Critical',
            'visibility'  => 'nullable|in:public,private',
        ]);

        $validated['visibility'] = $validated['visibility'] ?? 'public';

        // ✅ DUPLICATE CHECK: same location + overlapping date range
        if (!empty($validated['location'])) {
            $start = $validated['start_date'];
            $end   = $validated['end_date'] ?? $start;

            $hasConflict = CalendarEvent::query()
                ->where('location', $validated['location'])
                ->where(function ($q) use ($start, $end) {
                    // overlap: existing.start <= newEnd AND existing.end_or_start >= newStart
                    $q->where('start_date', '<=', $end)
                      ->whereRaw('COALESCE(end_date, start_date) >= ?', [$start]);
                })
                ->exists();

            if ($hasConflict) {
                return response()->json([
                    'message' => 'There is already an event at this location on the selected date range.',
                ], 422);
            }
        }

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
            'location'    => 'nullable|string|max:255',
            'priority'    => 'nullable|in:Low,Medium,High,Critical',
            'visibility'  => 'nullable|in:public,private',
        ]);

        // ✅ DUPLICATE CHECK on update as well (exclude self)
        if (!empty($validated['location'])) {
            $start = $validated['start_date'];
            $end   = $validated['end_date'] ?? $start;

            $hasConflict = CalendarEvent::query()
                ->where('location', $validated['location'])
                ->where('id', '!=', $event->id)
                ->where(function ($q) use ($start, $end) {
                    $q->where('start_date', '<=', $end)
                      ->whereRaw('COALESCE(end_date, start_date) >= ?', [$start]);
                })
                ->exists();

            if ($hasConflict) {
                return response()->json([
                    'message' => 'There is already an event at this location on the selected date range.',
                ], 422);
            }
        }

        // keep old priority if not sent
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
     */
    private function priorityColor(?string $priority): string
    {
        $priority = $priority ?? 'Medium';

        return match ($priority) {
            'Critical' => '#8B0000', // dark red
            'High'     => '#dc3545', // red
            'Medium'   => '#ffc107', // yellow
            'Low'      => '#28a745', // green
            default    => '#6c757d', // grey fallback
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
