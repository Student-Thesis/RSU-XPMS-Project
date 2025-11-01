@extends('layouts.app')

@section('content')
    {{-- FullCalendar CSS (page-only) --}}

    {{-- wrap whole page with a CLASS, not a 2nd id --}}
    <div id="content" class="calendar-page">
        @include('layouts.partials.topnav')

        <div class="midde_cont">
            <div class="container-fluid">
                {{-- title --}}
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h2 class="m-0">Project Events Calendar</h2>

                            {{-- optional top button (same style as faculties) --}}
                            <button type="button"
                                    class="btn btn-primary btn-xs"
                                    onclick="openAddEventModal()">
                                <i class="fa fa-plus"></i> Add Event
                            </button>
                        </div>
                    </div>
                </div>

                {{-- calendar card --}}
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
                        <input type="text" id="eventTitle" class="calendar-form-input" required placeholder="Enter project title...">
                    </div>
                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Description</label>
                        <textarea id="eventDescription" class="calendar-form-input calendar-form-textarea" placeholder="Enter project description..."></textarea>
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

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Color</label>
                        <div class="calendar-color-picker-container">
                            <div class="calendar-color-option selected" style="background-color: #007bff;" data-color="#007bff"></div>
                            <div class="calendar-color-option" style="background-color: #28a745;" data-color="#28a745"></div>
                            <div class="calendar-color-option" style="background-color: #dc3545;" data-color="#dc3545"></div>
                            <div class="calendar-color-option" style="background-color: #ffc107;" data-color="#ffc107"></div>
                            <div class="calendar-color-option" style="background-color: #6f42c1;" data-color="#6f42c1"></div>
                            <div class="calendar-color-option" style="background-color: #fd7e14;" data-color="#fd7e14"></div>
                            <div class="calendar-color-option" style="background-color: #20c997;" data-color="#20c997"></div>
                            <div class="calendar-color-option" style="background-color: #6c757d;" data-color="#6c757d"></div>
                        </div>
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

    {{-- FullCalendar JS --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

    <script>
        let currentCalendar;
        let currentSelectedEvent = null;
        let selectedColor = '#007bff';
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
                            info.el.setAttribute('title', info.event.title + '\n' + info.event.extendedProps.description);
                        }
                    }
                });

                currentCalendar.render();
            }

            setupColorPicker();
            setupFormSubmit();
        });

        function setupColorPicker() {
            const colorOptions = document.querySelectorAll('.calendar-color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function () {
                    colorOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedColor = this.dataset.color;
                });
            });
        }

        function openAddEventModal(dateStr = '') {
            editingEventId = null;
            document.getElementById('eventForm').reset();
            document.getElementById('addEventModalTitle').textContent = 'Add New Project Event';
            document.getElementById('eventSubmitBtn').textContent = 'Add Event';
            document.getElementById('eventDate').value = dateStr;
            document.getElementById('eventVisibility').value = 'public';

            // reset color
            document.querySelectorAll('.calendar-color-option').forEach(opt => opt.classList.remove('selected'));
            document.querySelector('.calendar-color-option[data-color="#007bff"]').classList.add('selected');
            selectedColor = '#007bff';

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
            const startDate = new Date(event.start);
            const endDate = event.end ? new Date(event.end) : null;
            const visibility = event.extendedProps.visibility || 'public';

            detailsContainer.innerHTML = `
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">Project Title:</div>
                    <div class="calendar-event-detail-value">
                        <span class="calendar-event-color-indicator" style="background-color: ${event.color || '#007bff'}"></span>
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
                ${endDate ? `
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">End Date:</div>
                    <div class="calendar-event-detail-value">${endDate.toLocaleDateString()}</div>
                </div>` : ''}
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">Project Type:</div>
                    <div class="calendar-event-detail-value">${event.extendedProps.type || 'Not specified'}</div>
                </div>
                <div class="calendar-event-detail">
                    <div class="calendar-event-detail-label">Priority:</div>
                    <div class="calendar-event-detail-value">
                        <span style="color: ${getPriorityColor(event.extendedProps.priority)}; font-weight: bold;">
                            ${event.extendedProps.priority || 'Medium'}
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

            // add Edit button once
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

        function getPriorityColor(priority) {
            switch (priority) {
                case 'Critical': return '#dc3545';
                case 'High': return '#fd7e14';
                case 'Medium': return '#ffc107';
                case 'Low': return '#28a745';
                default: return '#6c757d';
            }
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
                    priority: document.getElementById('eventPriority').value,
                    color: selectedColor,
                    visibility: document.getElementById('eventVisibility').value,
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

            document.getElementById('eventTitle').value = event.title;
            document.getElementById('eventDescription').value = event.extendedProps.description || '';
            document.getElementById('eventDate').value = event.startStr;
            document.getElementById('eventEndDate').value = event.endStr ? event.endStr.substring(0, 10) : '';
            document.getElementById('eventType').value = event.extendedProps.type || '';
            document.getElementById('eventPriority').value = event.extendedProps.priority || 'Medium';
            document.getElementById('eventVisibility').value = event.extendedProps.visibility || 'public';

            // color
            document.querySelectorAll('.calendar-color-option').forEach(opt => opt.classList.remove('selected'));
            const eventColor = event.backgroundColor || event.color || '#007bff';
            const colorEl = document.querySelector(`.calendar-color-option[data-color="${eventColor}"]`);
            if (colorEl) {
                colorEl.classList.add('selected');
                selectedColor = eventColor;
            } else {
                selectedColor = eventColor;
            }

            closeViewEventModal();
            document.getElementById('addEventModal').classList.add('show');
        }

        // click overlay to close
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('calendar-modal-overlay')) {
                if (e.target.id === 'addEventModal') closeAddEventModal();
                else if (e.target.id === 'viewEventModal') closeViewEventModal();
            }
        });

        // ESC to close
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeAddEventModal();
                closeViewEventModal();
            }
        });
    </script>

    <style>
        /* ⬇️ everything is scoped to the calendar page so it WON'T affect sidebar/topbar */
        .calendar-page #calendar {
            position: relative;
            z-index: 0 !important;
        }

       /* overlay stays the same */
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
.calendar-modal-overlay.show {
    display: flex !important;
}

/* container: width only */
.calendar-modal-container {
    position: relative;
    z-index: 1060;
    max-width: 540px;
    width: 100%;
}

/* ✨ make modal scrollable if taller than screen */
.calendar-modal-content {
    background: #fff;
    border-radius: .5rem;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    padding: 1.5rem 1.5rem 1.25rem;

    /* important part 👇 */
    max-height: calc(100vh - 2rem);  /* always fit inside screen */
    overflow-y: auto;                 /* scroll inside the modal */
}

/* keep header visible while scrolling (nice UX) */
.calendar-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;

    position: sticky;
    top: -1.5rem;   /* match top padding of .calendar-modal-content */
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

        .calendar-color-picker-container {
            display: flex;
            gap: .4rem;
            flex-wrap: wrap;
        }

        .calendar-color-option {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .calendar-color-option.selected {
            border-color: #000;
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

        /* like faculties page: don't touch global .btn-group */
        .calendar-btn-row {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }

        /* match your small button style */
        .btn-xs {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 3px 8px !important;
            font-size: 0.75rem !important;
            line-height: 1 !important;
            border-radius: 3px !important;
            height: 26px !important;
        }
    </style>
@endsection
