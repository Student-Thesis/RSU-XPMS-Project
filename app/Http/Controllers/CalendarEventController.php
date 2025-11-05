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

        return $events->map(function (CalendarEvent $event) {
            return [
                'id'    => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->toDateString(),
                'end'   => $event->end_date?->toDateString(),
                'color' => $event->color ?? '#007bff',
                'extendedProps' => [
                    'description' => $event->description,
                    'type'        => $event->type,
                    'priority'    => $event->priority,
                    'visibility'  => $event->visibility,
                    'created_by'  => $event->created_by,
                ],
            ];
        });
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
            'priority'    => 'nullable|string|max:50',
            'color'       => 'nullable|string|max:20',
            'visibility'  => 'nullable|in:public,private',
        ]);

        $validated['visibility'] = $validated['visibility'] ?? 'public';
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $event = CalendarEvent::create($validated);

        // 🔐 log here
        $this->logActivity('Created Calendar Event', [
            'event' => $event->toArray(),
        ]);

        return response()->json([
            'message' => 'Event created.',
            'event'   => [
                'id'    => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->toDateString(),
                'end'   => $event->end_date?->toDateString(),
                'color' => $event->color ?? '#007bff',
                'extendedProps' => [
                    'description' => $event->description,
                    'type'        => $event->type,
                    'priority'    => $event->priority,
                    'visibility'  => $event->visibility,
                    'created_by'  => $event->created_by,
                ],
            ],
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
            'priority'    => 'nullable|string|max:50',
            'color'       => 'nullable|string|max:20',
            'visibility'  => 'nullable|in:public,private',
        ]);

        $old = $event->toArray();

        $validated['updated_by'] = Auth::id();
        $event->update($validated);

        // 🔐 log here
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

        // 🔐 log here
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
     * 🧾 Local logging method (no trait)
     * Logs only from this controller.
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id'          => Str::uuid(),
            'user_id'     => Auth::id(),
            'notifiable_user_id' => Auth::id(),
            'action'      => $action,
            'model_type'  => CalendarEvent::class,
            'model_id'    => $changes['event']['id'] ?? null,
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
