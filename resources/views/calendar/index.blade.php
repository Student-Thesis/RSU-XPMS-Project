@extends('layouts.app')

@section('content')
    <div id="content" class="calendar-page">
        @include('layouts.partials.topnav')

        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h2 class="m-0">Project Events Calendar</h2>

                            <button type="button"
                                    class="btn btn-primary btn-xs"
                                    onclick="openAddEventModal()">
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

                    {{-- NEW: Location --}}
                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Location</label>
                        <input type="text" id="eventLocation" class="calendar-form-input">
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

                    {{-- REMOVED MANUAL COLOR PICKER – color now auto based on priority --}}

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
            document.getElementById('eventTitle').focus();
        }

        function closeAddEventModal() {
            document.getElementById('addEventModal').classList.remove('show');
            editingEventId = null;
        }

        function showEventDetails(event) {
            const modal = document.getElementById('viewEventModal');
            const detailsContainer = document.getElementById('eventDetails');

            const rangeStartStr = event.extendedProps.range_start || event.startStr.substring(0, 10);
            const rangeEndStr   = event.extendedProps.range_end   || rangeStartStr;

            const startDate = new Date(rangeStartStr);
            const endDate   = new Date(rangeEndStr);
            const visibility = event.extendedProps.visibility || 'public';
            const priority  = event.extendedProps.priority || 'Medium';
            const priorityColor = getPriorityColor(priority);

            detailsContainer.innerHTML = `
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">Project Title:</div>
                    <div class="calendar-event-detail-value">
                        <span class="calendar-event-color-indicator" style="background-color:${priorityColor}"></span>
                        ${event.title}
                    </div>
                </div>
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">Description:</div>
                    <div class="calendar-event-detail-value">${event.extendedProps.description || 'No description provided'}</div>
                </div>
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">Start Date:</div>
                    <div class="calendar-event-detail-value">${startDate.toLocaleDateString()}</div>
                </div>
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">End Date:</div>
                    <div class="calendar-event-detail-value">${endDate.toLocaleDateString()}</div>
                </div>
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">Project Type:</div>
                    <div class="calendar-event-detail-value">${event.extendedProps.type || 'Not specified'}</div>
                </div>
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">Location:</div>
                    <div class="calendar-event-detail-value">${event.extendedProps.location || 'Not specified'}</div>
                </div>
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">Priority:</div>
                    <div class="calendar-event-detail-value">
                        <span style="color:${priorityColor};font-weight:bold;">
                            ${priority}
                        </span>
                    </div>
                </div>
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">Visibility:</div>
                    <div class="calendar-event-detail-value">
                        ${visibility === 'private'
                            ? '<span style="color:#dc3545;font-weight:bold;">Private</span>'
                            : '<span style="color:#28a745;font-weight:bold;">Public</span>'
                        }
                    </div>
                </div>
            `;

            const btnRow = modal.querySelector('.calendar-btn-row');
            if (!btnRow.querySelector('.btn-edit-event')) {
                const editBtn = document.createElement('button');
                editBtn.type = 'button';
                editBtn.className = 'btn btn-primary btn-edit-event';
                editBtn.textContent = 'Edit Event';
                editBtn.onclick = () => editEvent(event);
                btnRow.insertBefore(editBtn, btnRow.firstChild);
            }

            modal.classList.add('show');
        }

        function closeViewEventModal() {
            document.getElementById('viewEventModal').classList.remove('show');
            currentSelectedEvent = null;
        }

        // Priority → Color mapping (Low/Medium/High)
        function getPriorityColor(priority) {
            switch (priority) {
                case 'High':     return '#dc3545'; // red
                case 'Medium':   return '#ffc107'; // yellow
                case 'Low':      return '#28a745'; // green
                default:         return '#6c757d'; // grey fallback
            }
        }

        function setupFormSubmit() {
            document.getElementById('eventForm').addEventListener('submit', async function (e) {
                e.preventDefault();

                const priority = document.getElementById('eventPriority').value || 'Medium';
                const payload = {
                    title:       document.getElementById('eventTitle').value,
                    description: document.getElementById('eventDescription').value,
                    start_date:  document.getElementById('eventDate').value,
                    end_date:    document.getElementById('eventEndDate').value || null,
                    type:        document.getElementById('eventType').value,
                    location:    document.getElementById('eventLocation').value,
                    priority:    priority,
                    // Color is now auto-derived from priority
                    color:       getPriorityColor(priority),
                    visibility:  document.getElementById('eventVisibility').value,
                };

                const url = editingEventId
                    ? `/calendar/events/${editingEventId}`
                    : `{{ route('calendar.events.store') }}`;

                const method = editingEventId ? 'PUT' : 'POST';

                const res = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    currentCalendar.refetchEvents();
                    closeAddEventModal();
                    closeViewEventModal();
                } else {
                    console.error(await res.json().catch(() => ({})));
                    alert('Failed to save event.');
                }
            });
        }

        async function deleteEvent() {
            if (!currentSelectedEvent) return;
            if (!confirm('Delete this event?')) return;

            const res = await fetch(`/calendar/events/${currentSelectedEvent.id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            if (res.ok) {
                currentCalendar.refetchEvents();
                closeViewEventModal();
            } else {
                alert('Failed to delete event.');
            }
        }

        window.deleteEvent = deleteEvent;

        function editEvent(event) {
            editingEventId = event.id;
            document.getElementById('addEventModalTitle').textContent = 'Edit Project Event';
            document.getElementById('eventSubmitBtn').textContent = 'Update Event';

            const rangeStartStr = event.extendedProps.range_start || event.startStr.substring(0, 10);
            const rangeEndStr   = event.extendedProps.range_end   || rangeStartStr;

            document.getElementById('eventTitle').value       = event.title;
            document.getElementById('eventDescription').value = event.extendedProps.description || '';
            document.getElementById('eventDate').value        = rangeStartStr;
            document.getElementById('eventEndDate').value     = rangeEndStr;
            document.getElementById('eventType').value        = event.extendedProps.type || '';
            document.getElementById('eventLocation').value    = event.extendedProps.location || '';
            document.getElementById('eventPriority').value    = event.extendedProps.priority || 'Medium';
            document.getElementById('eventVisibility').value  = event.extendedProps.visibility || 'public';

            closeViewEventModal();
            document.getElementById('addEventModal').classList.add('show');
        }

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('calendar-modal-overlay')) {
                if (e.target.id === 'addEventModal') closeAddEventModal();
                else if (e.target.id === 'viewEventModal') closeViewEventModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeAddEventModal();
                closeViewEventModal();
            }
        });
    </script>

    <style>
        .calendar-page #calendar {
            position: relative;
            z-index: 0 !important;
        }

        .calendar-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            padding: 1rem;
        }
        .calendar-modal-overlay.show { display:flex !important; }

        .calendar-modal-container {
            position: relative;
            z-index: 1060;
            max-width: 540px;
            width: 100%;
        }

        .calendar-modal-content {
            background: #fff;
            border-radius: .5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            padding: 1.5rem 1.5rem 1.25rem;
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
        }

        .calendar-modal-header {
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:1rem;
            position:sticky;
            top:-1.5rem;
            background:#fff;
            padding-top:1.5rem;
            z-index:1;
        }

        .calendar-close-btn {
            background:transparent;
            border:none;
            font-size:1.5rem;
            line-height:1;
            cursor:pointer;
        }

        .calendar-form-group { margin-bottom:.75rem; }
        .calendar-form-label { display:block;font-weight:600;margin-bottom:.35rem; }

        .calendar-form-input,
        .calendar-form-textarea {
            width:100%;
            border:1px solid #ced4da;
            border-radius:.25rem;
            padding:.4rem .6rem;
        }
        .calendar-form-textarea { min-height:80px;resize:vertical; }

        .calendar-event-detail { display:flex;gap:.5rem;margin-bottom:.35rem; }
        .calendar-event-detail-label { width:110px;font-weight:600;color:#555; }
        .calendar-event-detail-value { flex:1; }

        .calendar-event-color-indicator {
            display:inline-block;width:10px;height:10px;border-radius:50%;margin-right:.25rem;
        }

        .calendar-btn-row { display:flex;gap:.5rem;flex-wrap:wrap; }

        .btn-xs {
            display:inline-flex;align-items:center;justify-content:center;gap:4px;
            padding:3px 8px !important;font-size:.75rem !important;line-height:1 !important;
            border-radius:3px !important;height:26px !important;
        }
    </style>
@endsection
