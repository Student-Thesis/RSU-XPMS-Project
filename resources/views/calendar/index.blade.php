@extends('layouts.app')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-sm-6">
                    <h3 class="mb-0">Project Events Calendar</h3>
                </div>

                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <button type="button"
                            class="btn btn-success btn-sm"
                            onclick="openAddEventModal()">
                        <i class="bi bi-plus-lg"></i> Add Event
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="app-content calendar-page">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title mb-0">Calendar</h3>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>

        </div>
    </div>

    {{-- ADD / EDIT EVENT MODAL (single modal for both) --}}
    <div id="addEventModal" class="calendar-modal-overlay">
        <div class="calendar-modal-container">
            <div class="calendar-modal-content">
                <div class="calendar-modal-header">
                    <h3 class="calendar-modal-title" id="addEventModalTitle">Add New Project Event</h3>
                    <button class="calendar-close-btn" type="button" onclick="closeAddEventModal()">&times;</button>
                </div>

                <form id="eventForm">
                    @csrf

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Project Title *</label>
                        <input type="text" id="eventTitle" class="calendar-form-input" required>
                    </div>

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Description</label>
                        <textarea id="eventDescription"
                                  class="calendar-form-input calendar-form-textarea"></textarea>
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
                           
                        </label>

                         <input type="text"
           id="eventLocation"
           class="calendar-form-input"
           placeholder="Enter location (e.g. Room 201, Main Building)">
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
                            <option value="Low" style="background:rgb(46, 136, 46)">Low</option>
                            <option value="Medium" style="background:rgb(136, 127, 46)" selected>Medium</option>
                            <option value="High" style="background:rgb(136, 73, 46)">High</option>
                            <option value="Critical" style="background:rgb(136, 46, 46)">Critical</option>
                        </select>
                    </div>

                    <div class="calendar-btn-row mt-3">
                        {{-- Delete button shown ONLY when editing --}}
                        <button type="button"
                                class="btn btn-danger me-auto d-none"
                                id="eventDeleteBtn"
                                onclick="deleteEventFromEdit()">
                            <i class="bi bi-trash"></i> Delete
                        </button>

                        <button type="button" class="btn btn-secondary" onclick="closeAddEventModal()">
                            <i class="bi bi-x-lg"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="eventSubmitBtn">
                            <i class="bi bi-save"></i> Add Event
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css"/>

    <style>
        .calendar-page #calendar {
            min-height: 400px;
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
            background: #fff;
            color:black;
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: .4rem .6rem;
        }

        .calendar-form-textarea {
            min-height: 80px;
            resize: vertical;
        }

        .calendar-btn-row {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        let projectCalendar = null;
        let editingEventId = null;

        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            if (!calendarEl) return;

            projectCalendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                selectable: true,
                editable: false,
                height: 'auto',

                events: {
                    url: '{{ route('calendar.events.index') }}',
                    method: 'GET',
                },

                dateClick: function (info) {
                    openAddEventModal(info.dateStr);
                },

                eventClick: function (info) {
                    openEditEventModal(info.event);
                },

                eventDidMount: function (info) {
                    const desc = info.event.extendedProps.description;
                    if (desc) {
                        info.el.setAttribute('title', info.event.title + '\n' + desc);
                    }
                }
            });

            projectCalendar.render();
            setupFormSubmit();
        });

        // ===== MODALS =====

        function openAddEventModal(dateStr = '') {
            editingEventId = null;

            const form = document.getElementById('eventForm');
            form.reset();

            document.getElementById('addEventModalTitle').textContent = 'Add New Project Event';
            document.getElementById('eventSubmitBtn').textContent = 'Add Event';
            document.getElementById('eventDeleteBtn').classList.add('d-none');

            document.getElementById('eventDate').value = dateStr || '';
            document.getElementById('eventVisibility').value = 'public';
            document.getElementById('eventPriority').value = 'Medium';

            document.getElementById('addEventModal').classList.add('show');
        }
        window.openAddEventModal = openAddEventModal;

        function openEditEventModal(event) {
            editingEventId = event.id;

            const props = event.extendedProps || {};

            document.getElementById('addEventModalTitle').textContent = 'Edit Project Event';
            document.getElementById('eventSubmitBtn').textContent = 'Update Event';
            document.getElementById('eventDeleteBtn').classList.remove('d-none');

            document.getElementById('eventTitle').value = event.title || '';
            document.getElementById('eventDescription').value = props.description || '';

            // start/end as YYYY-MM-DD
            document.getElementById('eventDate').value = event.startStr ? event.startStr.substring(0, 10) : '';
            document.getElementById('eventEndDate').value =
                event.endStr ? event.endStr.substring(0, 10) : (props.end_date || '');

            document.getElementById('eventType').value = props.type || '';
            document.getElementById('eventLocation').value = props.location || '';
            document.getElementById('eventVisibility').value = props.visibility || 'public';
            document.getElementById('eventPriority').value = props.priority || 'Medium';

            document.getElementById('addEventModal').classList.add('show');
        }

        function closeAddEventModal() {
            document.getElementById('addEventModal').classList.remove('show');
            editingEventId = null;
        }
        window.closeAddEventModal = closeAddEventModal;

        // ===== CREATE / UPDATE =====

        function setupFormSubmit() {
            const form = document.getElementById('eventForm');
            if (!form) return;

            form.addEventListener('submit', async function (e) {
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
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Network Error',
                            text: 'Unable to contact the server.',
                        });
                    }
                    return;
                }

                if (res.redirected) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Access Denied',
                            text: 'You do not have permission to save events.',
                        });
                    }
                    return;
                }

                if (res.ok) {
                    projectCalendar?.refetchEvents();
                    closeAddEventModal();

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: editingEventId ? 'Event Updated' : 'Event Created',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                    return;
                }

                let data = {};
                try {
                    data = await res.json();
                } catch (_) {}

                let msg = data.message || 'Failed to save event.';

                if (data.errors) {
                    const firstErrorKey = Object.keys(data.errors)[0];
                    msg = data.errors[firstErrorKey][0];
                }

                if (res.status === 403) {
                    msg = "You don't have permission to perform this action.";
                }

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cannot Save Event',
                        text: msg,
                    });
                }
            });
        }

        // ===== DELETE FROM EDIT MODAL =====

        async function deleteEventFromEdit() {
            if (!editingEventId || typeof Swal === 'undefined') return;

            const confirmResult = await Swal.fire({
                icon: 'warning',
                title: 'Delete event?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
            });

            if (!confirmResult.isConfirmed) return;

            let res;

            try {
                res = await fetch(`/calendar/events/${editingEventId}`, {
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

            if (res.redirected) {
                Swal.fire({
                    icon: 'error',
                    title: 'Permission Denied',
                    text: 'You cannot delete calendar events.',
                });
                return;
            }

            if (res.ok) {
                projectCalendar?.refetchEvents();
                closeAddEventModal();
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
        window.deleteEventFromEdit = deleteEventFromEdit;
    </script>
@endpush
