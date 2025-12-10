@extends('layouts.app')

@section('content')
    <div id="content" class="calendar-page">

        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h2 class="m-0">Project Events Calendar</h2>

                            <button type="button" class="btn btn-success btn-sm" onclick="openAddEventModal()">
                                <i class="fa fa-plus"></i> Add Event
                            </button>
                        </div>
                    </div>
                </div>

                <div class="white_shd full margin_bottom_30 mt-3">
                    <div class="full">
                        <div class="full graph_head">
                            <div class="heading1 margin_0 d-flex align-items-center justify-content-between">
                                <h4 class="m-0">Calendar</h4>
                            </div>
                        </div>
                        <div class="full padding_infor_info">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Add / Edit Event Modal --}}
    <div id="addEventModal" class="calendar-modal-overlay">
        <div class="calendar-modal-container">
            <div class="calendar-modal-content">
                <div class="calendar-modal-header">
                    <h3 class="calendar-modal-title" id="addEventModalTitle">Add New Project Event</h3>
                    <button class="calendar-close-btn" onclick="closeAddEventModal()">&times;</button>
                </div>
                <form id="eventForm">
                    @csrf
                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Project Title *</label>
                        <input type="text" id="eventTitle" class="calendar-form-input" required>
                    </div>

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Description</label>
                        <textarea id="eventDescription" class="calendar-form-input calendar-form-textarea"></textarea>
                    </div>

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Date *</label>
                        <input type="date" id="eventDate" class="calendar-form-input" required>
                    </div>

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">End Date (Optional)</label>
                        <input type="date" id="eventEndDate" class="calendar-form-input">
                    </div>

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Project Type</label>
                        <select id="eventType" class="calendar-form-input">
                            <option value="">Select project type...</option>
                            <option value="Development">Development</option>
                            <option value="Testing">Testing</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Deadline">Deadline</option>
                            <option value="Review">Review</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    {{-- Location --}}
                    <div class="calendar-form-group">
                        <label class="calendar-form-label d-flex justify-content-between align-items-center">
                            <span>Location</span>
                            <a href="{{ route('event-locations.index') }}" target="_blank" class="small text-primary">
                                <i class="fa fa-plus-circle"></i> Manage
                            </a>
                        </label>

                        <select id="eventLocation" class="calendar-form-input">
                            <option value="">Select location...</option>
                            @foreach($eventLocations as $loc)
                                <option value="{{ $loc->name }}">
                                    {{ $loc->name }}{{ $loc->room ? ' - ' . $loc->room : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Visibility</label>
                        <select id="eventVisibility" class="calendar-form-input">
                            <option value="public" selected>Public</option>
                            <option value="private">Private</option>
                        </select>
                    </div>

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Priority</label>
                        <select id="eventPriority" class="calendar-form-input">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                            <option value="Critical">Critical</option>
                        </select>
                    </div>

                    <div class="calendar-btn-row mt-3">
                        <button type="button" class="btn btn-secondary" onclick="closeAddEventModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="eventSubmitBtn">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- View Event Modal --}}
    <div id="viewEventModal" class="calendar-modal-overlay">
        <div class="calendar-modal-container">
            <div class="calendar-modal-content">
                <div class="calendar-modal-header">
                    <h3 class="calendar-modal-title">Project Event Details</h3>
                    <button class="calendar-close-btn" onclick="closeViewEventModal()">&times;</button>
                </div>
                <div id="eventDetails"></div>
                <div class="calendar-btn-row mt-3">
                    <button type="button" class="btn btn-danger" onclick="deleteEvent()">Delete Event</button>
                    <button type="button" class="btn btn-secondary" onclick="closeViewEventModal()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

  <script>
    let currentCalendar;
    let currentSelectedEvent = null;
    let editingEventId = null;

    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        if (calendarEl) {
            currentCalendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: false,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                height: 'auto',
                events: '{{ route('calendar.events.index') }}',

                dateClick: function (info) {
                    openAddEventModal(info.dateStr);
                },

                eventClick: function (info) {
                    currentSelectedEvent = info.event;
                    showEventDetails(info.event);
                },

                eventDidMount: function (info) {
                    if (info.event.extendedProps.description) {
                        info.el.setAttribute(
                            'title',
                            info.event.title + '\n' + info.event.extendedProps.description
                        );
                    }
                }
            });

            currentCalendar.render();
        }

        setupFormSubmit();
    });

    function openAddEventModal(dateStr = '') {
        editingEventId = null;
        document.getElementById('eventForm').reset();
        document.getElementById('addEventModalTitle').textContent = 'Add New Project Event';
        document.getElementById('eventSubmitBtn').textContent = 'Add Event';
        document.getElementById('eventDate').value = dateStr;
        document.getElementById('eventVisibility').value = 'public';
        document.getElementById('eventPriority').value = 'Medium';

        document.getElementById('addEventModal').classList.add('show');
    }

    function closeAddEventModal() {
        document.getElementById('addEventModal').classList.remove('show');
        editingEventId = null;
    }

    function setupFormSubmit() {
        document.getElementById('eventForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const payload = {
                title: document.getElementById('eventTitle').value,
                description: document.getElementById('eventDescription').value,
                start_date: document.getElementById('eventDate').value,
                end_date: document.getElementById('eventEndDate').value || null,
                type: document.getElementById('eventType').value,
                location: document.getElementById('eventLocation').value,
                priority: document.getElementById('eventPriority').value || 'Medium',
                visibility: document.getElementById('eventVisibility').value,
            };

            const url = editingEventId
                ? `/calendar/events/${editingEventId}`
                : `{{ route('calendar.events.store') }}`;

            const method = editingEventId ? 'PUT' : 'POST';

            let res;

            try {
                res = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
            } catch (networkError) {
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Unable to contact the server.',
                });
                return;
            }

            // 🔥 CASE 1: Middleware redirected → HTML, not JSON
            if (res.redirected) {
                Swal.fire({
                    icon: 'error',
                    title: 'Access Denied',
                    text: 'You do not have permission to create or update calendar events.',
                });
                return;
            }

            // 🔥 CASE 2: Success
            if (res.ok) {
                currentCalendar.refetchEvents();
                closeAddEventModal();
                Swal.fire({
                    icon: 'success',
                    title: editingEventId ? 'Event Updated' : 'Event Created',
                    timer: 1500,
                    showConfirmButton: false
                });
                return;
            }

            // 🔥 CASE 3: Try parsing JSON error message
            let data = {};
            try {
                data = await res.json();
            } catch (err) {
                // HTML from middleware OR server error
            }

            let msg = data.message || 'Failed to save event.';

            // Laravel validation errors
            if (data.errors) {
                const firstErrorKey = Object.keys(data.errors)[0];
                msg = data.errors[firstErrorKey][0];
            }

            // HTTP permission error
            if (res.status === 403) {
                msg = "You don't have permission to perform this action.";
            }

            Swal.fire({
                icon: 'error',
                title: 'Cannot Save Event',
                text: msg,
            });
        });
    }

    async function deleteEvent() {
        if (!currentSelectedEvent) return;

        const confirm = await Swal.fire({
            icon: 'warning',
            title: 'Delete event?',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
        });

        if (!confirm.isConfirmed) return;

        const id = currentSelectedEvent.id;

        let res;

        try {
            res = await fetch(`/calendar/events/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
        } catch (networkErr) {
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'Could not contact server.',
            });
            return;
        }

        // Middleware redirect
        if (res.redirected) {
            Swal.fire({
                icon: 'error',
                title: 'Permission Denied',
                text: 'You cannot delete calendar events.',
            });
            return;
        }

        if (res.ok) {
            currentCalendar.refetchEvents();
            closeViewEventModal();
            Swal.fire({
                icon: 'success',
                title: 'Event Deleted',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Failed to Delete Event',
                text: 'Something went wrong.',
            });
        }
    }

    window.deleteEvent = deleteEvent;
</script>

    <style>
        .calendar-page #calendar {
            position: relative;
            z-index: 0 !important;
        }

        .calendar-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            padding: 1rem;
        }

        .calendar-modal-overlay.show {
            display: flex !important;
        }

        .calendar-modal-container {
            position: relative;
            z-index: 1060;
            max-width: 540px;
            width: 100%;
        }

        .calendar-modal-content {
            background: #fff;
            border-radius: .5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 1.5rem 1.5rem 1.25rem;
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
        }

        .calendar-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            position: sticky;
            top: -1.5rem;
            background: #fff;
            padding-top: 1.5rem;
            z-index: 1;
        }

        .calendar-close-btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            line-height: 1;
            cursor: pointer;
        }

        .calendar-form-group {
            margin-bottom: .75rem;
        }

        .calendar-form-label {
            display: block;
            font-weight: 600;
            margin-bottom: .35rem;
        }

        .calendar-form-input,
        .calendar-form-textarea {
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: .4rem .6rem;
        }

        .calendar-form-textarea {
            min-height: 80px;
            resize: vertical;
        }

        .calendar-event-detail {
            display: flex;
            gap: .5rem;
            margin-bottom: .35rem;
        }

        .calendar-event-detail-label {
            width: 110px;
            font-weight: 600;
            color: #555;
        }

        .calendar-event-detail-value {
            flex: 1;
        }

        .calendar-event-color-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: .25rem;
        }

        .calendar-btn-row {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }
    </style>
@endsection
