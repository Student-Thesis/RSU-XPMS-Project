@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />

    <div id="content">
        @include('layouts.partials.topnav')

        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h2>Project Events Calendar</h2>
                        </div>
                    </div>
                </div>

              <div class="white_shd full margin_bottom_30">
    <div class="full">
        <div class="full graph_head">
            <div class="heading1 margin_0 d-flex align-items-center justify-content-between">
               
                <div class="ms-auto">
                    <button type="button"
                            class="btn btn-primary btn-sm"
                            onclick="openAddEventModal()"
                            style="padding:5px 10px;margin:0;">
                        <i class="fa fa-plus"></i> Add Event
                    </button>
                </div>
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

    <!-- Add / Edit Event Modal -->
    <div id="addEventModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="addEventModalTitle">Add New Project Event</h3>
                    <button class="close-btn" onclick="closeAddEventModal()">&times;</button>
                </div>
                <form id="eventForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Project Title *</label>
                        <input type="text" id="eventTitle" class="form-input" placeholder="Enter project title..." required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea id="eventDescription" class="form-input form-textarea" placeholder="Enter project description..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date *</label>
                        <input type="date" id="eventDate" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Date (Optional)</label>
                        <input type="date" id="eventEndDate" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Project Type</label>
                        <select id="eventType" class="form-input">
                            <option value="">Select project type...</option>
                            <option value="Development">Development</option>
                            <option value="Testing">Testing</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Deadline">Deadline</option>
                            <option value="Review">Review</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Visibility</label>
                        <select id="eventVisibility" class="form-input">
                            <option value="public" selected>Public</option>
                            <option value="private">Private</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Priority</label>
                        <select id="eventPriority" class="form-input">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                            <option value="Critical">Critical</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Color</label>
                        <div class="color-picker-container">
                            <div class="color-option selected" style="background-color: #007bff;" data-color="#007bff"></div>
                            <div class="color-option" style="background-color: #28a745;" data-color="#28a745"></div>
                            <div class="color-option" style="background-color: #dc3545;" data-color="#dc3545"></div>
                            <div class="color-option" style="background-color: #ffc107;" data-color="#ffc107"></div>
                            <div class="color-option" style="background-color: #6f42c1;" data-color="#6f42c1"></div>
                            <div class="color-option" style="background-color: #fd7e14;" data-color="#fd7e14"></div>
                            <div class="color-option" style="background-color: #20c997;" data-color="#20c997"></div>
                            <div class="color-option" style="background-color: #6c757d;" data-color="#6c757d"></div>
                        </div>
                    </div>
                    <div class="btn-group mt-3">
                        <button type="button" class="btn btn-secondary" onclick="closeAddEventModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="eventSubmitBtn">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Event Modal -->
    <div id="viewEventModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Project Event Details</h3>
                    <button class="close-btn" onclick="closeViewEventModal()">&times;</button>
                </div>
                <div id="eventDetails"></div>
                <div class="btn-group mt-3">
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
        let selectedColor = '#007bff';
        let editingEventId = null;

        document.addEventListener('DOMContentLoaded', function() {
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
                    dateClick: function(info) {
                        openAddEventModal(info.dateStr);
                    },
                    eventClick: function(info) {
                        currentSelectedEvent = info.event;
                        showEventDetails(info.event);
                    },
                    eventDidMount: function(info) {
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
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
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

            document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
            document.querySelector('.color-option[data-color="#007bff"]').classList.add('selected');
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
                <div class="event-detail">
                    <div class="event-detail-label">Project Title:</div>
                    <div class="event-detail-value">
                        <span class="event-color-indicator" style="background-color: ${event.color || '#007bff'}"></span>
                        ${event.title}
                    </div>
                </div>
                <div class="event-detail">
                    <div class="event-detail-label">Description:</div>
                    <div class="event-detail-value">${event.extendedProps.description || 'No description provided'}</div>
                </div>
                <div class="event-detail">
                    <div class="event-detail-label">Start Date:</div>
                    <div class="event-detail-value">${startDate.toLocaleDateString()}</div>
                </div>
                ${endDate ? `
                <div class="event-detail">
                    <div class="event-detail-label">End Date:</div>
                    <div class="event-detail-value">${endDate.toLocaleDateString()}</div>
                </div>` : ''}
                <div class="event-detail">
                    <div class="event-detail-label">Project Type:</div>
                    <div class="event-detail-value">${event.extendedProps.type || 'Not specified'}</div>
                </div>
                <div class="event-detail">
                    <div class="event-detail-label">Priority:</div>
                    <div class="event-detail-value">
                        <span style="color: ${getPriorityColor(event.extendedProps.priority)}; font-weight: bold;">
                            ${event.extendedProps.priority || 'Medium'}
                        </span>
                    </div>
                </div>
                <div class="event-detail">
                    <div class="event-detail-label">Visibility:</div>
                    <div class="event-detail-value">
                        ${visibility === 'private'
                            ? '<span style="color:#dc3545;font-weight:bold;">Private</span>'
                            : '<span style="color:#28a745;font-weight:bold;">Public</span>'
                        }
                    </div>
                </div>
            `;

            const btnGroup = modal.querySelector('.btn-group');
            if (!btnGroup.querySelector('.btn-edit-event')) {
                const editBtn = document.createElement('button');
                editBtn.type = 'button';
                editBtn.className = 'btn btn-primary btn-edit-event';
                editBtn.textContent = 'Edit Event';
                editBtn.onclick = () => editEvent(event);
                btnGroup.insertBefore(editBtn, btnGroup.firstChild);
            }

            document.getElementById('viewEventModal').classList.add('show');
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
            document.getElementById('eventForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const title = document.getElementById('eventTitle').value;
                const description = document.getElementById('eventDescription').value;
                const startDate = document.getElementById('eventDate').value;
                const endDate = document.getElementById('eventEndDate').value;
                const type = document.getElementById('eventType').value;
                const priority = document.getElementById('eventPriority').value;
                const visibility = document.getElementById('eventVisibility').value;

                const payload = {
                    title: title,
                    description: description,
                    start_date: startDate,
                    end_date: endDate || null,
                    type: type,
                    priority: priority,
                    color: selectedColor,
                    visibility: visibility,
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
                    const err = await res.json().catch(() => ({}));
                    console.error(err);
                    alert('Failed to save event.');
                }
            });
        }

        async function deleteEvent() {
            if (!currentSelectedEvent) return;
            if (!confirm('Are you sure you want to delete this event?')) return;

            const id = currentSelectedEvent.id;

            const res = await fetch(`/calendar/events/${id}`, {
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

            document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
            const eventColor = event.backgroundColor || event.color || '#007bff';
            const colorEl = document.querySelector(`.color-option[data-color="${eventColor}"]`);
            if (colorEl) {
                colorEl.classList.add('selected');
                selectedColor = eventColor;
            } else {
                selectedColor = eventColor;
            }

            closeViewEventModal();
            document.getElementById('addEventModal').classList.add('show');
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                if (e.target.id === 'addEventModal') closeAddEventModal();
                else if (e.target.id === 'viewEventModal') closeViewEventModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddEventModal();
                closeViewEventModal();
            }
        });
    </script>

    <style>
        #calendar {
            position: relative;
            z-index: 0 !important;
        }

        /* center-center for ALL modals */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            display: none;              /* hidden by default */
            align-items: center;
            justify-content: center;
            z-index: 1050;
            padding: 1rem;
        }

        /* when visible */
        .modal-overlay.show {
            display: flex !important;
        }

        .modal-container {
            position: relative;
            z-index: 1060;
            max-width: 540px;
            width: 100%;
        }

        .modal-content {
            background: #fff;
            border-radius: .5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            padding: 1.5rem 1.5rem 1.25rem;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .modal-title {
            font-size: 1.15rem;
            margin: 0;
        }

        .close-btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            line-height: 1;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: .75rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: .35rem;
        }

        .form-input, .form-textarea {
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: .4rem .6rem;
        }

        .form-textarea {
            min-height: 80px;
            resize: vertical;
        }

        .color-picker-container {
            display: flex;
            gap: .4rem;
            flex-wrap: wrap;
        }

        .color-option {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .color-option.selected {
            border-color: #000;
        }

        .event-detail {
            display: flex;
            gap: .5rem;
            margin-bottom: .35rem;
        }

        .event-detail-label {
            width: 110px;
            font-weight: 600;
            color: #555;
        }

        .event-detail-value {
            flex: 1;
        }

        .event-color-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: .25rem;
        }
    </style>
@endsection
