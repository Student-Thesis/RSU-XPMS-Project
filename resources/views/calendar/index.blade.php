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
                    <button type="button" class="btn btn-success btn-sm" onclick="openAddEventModal()">
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

    {{-- ADD / VIEW / EDIT EVENT MODAL --}}
    <div id="addEventModal" class="calendar-modal-overlay">
        <div class="calendar-modal-container">
            <div class="calendar-modal-content">

                <div class="calendar-modal-header">
                    <h3 class="calendar-modal-title" id="addEventModalTitle">
                        Add New Project Event
                    </h3>
                    <button class="calendar-close-btn" type="button" onclick="closeAddEventModal()">
                        &times;
                    </button>
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
                        <div class="calendar-input-wrapper">
                            <input type="date" id="eventDate" class="calendar-form-input" required>
                            <span class="calendar-icon">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                        </div>
                    </div>

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">End Date (Optional)</label>
                        <div class="calendar-input-wrapper">
                            <input type="date" id="eventEndDate" class="calendar-form-input">
                            <span class="calendar-icon">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                        </div>
                    </div>

                    <div class="calendar-form-group">
                        <label class="calendar-form-label">Project Type *</label>
                        <select id="eventType" class="calendar-form-input" required>
                            <option value="" disabled selected hidden>
                                Select project type...
                            </option>
                            <option value="Development">Development</option>
                            <option value="Testing">Testing</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Deadline">Deadline</option>
                            <option value="Review">Review</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

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
                            <option value="Low" style="background: rgb(11, 134, 0)">Low</option>
                            <option value="Medium" style="background: rgb(221, 255, 0)" selected>Medium</option>
                            <option value="High" style="background: rgb(255, 106, 0)">High</option>
                            <option value="Critical" style="background: red">Critical</option>
                        </select>
                    </div>

                    {{-- BUTTON ROW --}}
                    <div class="calendar-btn-row mt-3">

                        {{-- VIEW MODE --}}
                        <button type="button" class="btn btn-primary me-auto d-none" id="eventEditBtn"
                            onclick="enterEditMode()">
                            <i class="bi bi-pencil"></i> Edit
                        </button>

                        {{-- EDIT MODE --}}
                        <button type="button" class="btn btn-danger me-auto d-none" id="eventDeleteBtn"
                            onclick="deleteEventFromEdit()">
                            <i class="bi bi-trash"></i> Delete
                        </button>

                        <button type="button" class="btn btn-secondary" id="eventCancelBtn"
                            onclick="closeAddEventModal()">
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

{{-- ================= STYLES ================= --}}
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css">

    <style>
        .calendar-page #calendar {
            min-height: 400px;
        }

        .calendar-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .4);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1050;
        }

        .calendar-modal-overlay.show {
            display: flex;
        }

        .calendar-modal-container {
            max-width: 540px;
            width: 100%;
        }

        .calendar-modal-content {
            background: #fff;
            border-radius: .5rem;
            padding: 1.5rem;
            max-height: 90vh;
            overflow-y: auto;
        }

        .calendar-modal-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .calendar-form-group {
            margin-bottom: .75rem;
        }

        .calendar-form-label {
            font-weight: 600;
            margin-bottom: .35rem;
            display: block;
        }

        .calendar-form-input,
        .calendar-form-textarea {
            width: 100%;
            padding: .45rem .6rem;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .calendar-form-textarea {
            min-height: 80px;
        }

        .calendar-input-wrapper {
            position: relative;
        }

        .calendar-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .calendar-btn-row {
            display: flex;
            gap: .5rem;
        }

        /* ===== Calendar Modal – Light Inputs Override ===== */
        .calendar-modal-content input,
        .calendar-modal-content textarea,
        .calendar-modal-content select {
            background-color: transparent !important;
            color: #212529 !important;
            border: 1px solid #ced4da !important;
        }

        /* Placeholder text */
        .calendar-modal-content ::placeholder {
            color: #6c757d !important;
            opacity: 1;
        }

        /* Focus state */
        .calendar-modal-content input:focus,
        .calendar-modal-content textarea:focus,
        .calendar-modal-content select:focus {
            background-color: transparent !important;
            color: #212529 !important;
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, .25);
        }

        /* Disabled (VIEW MODE) */
        .calendar-modal-content input:disabled,
        .calendar-modal-content textarea:disabled,
        .calendar-modal-content select:disabled {
            background-color: #f8f9fa !important;
            color: #495057 !important;
            cursor: not-allowed;
        }

        /* ===== Priority Color Mapping (matches calendar) ===== */
        .priority-Low {
            background-color: #28a745 !important;
            /* green */
            color: #fff !important;
        }

        .priority-Medium {
            background-color: #ffc107 !important;
            /* yellow */
            color: #212529 !important;
        }

        .priority-High {
            background-color: #dc3545 !important;
            /* red */
            color: #fff !important;
        }

        .priority-Critical {
            background-color: #8B0000 !important;
            /* dark red */
            color: #fff !important;
        }

        /* ===== FORCE PRIORITY SELECT COLOR ===== */
        #eventPriority {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

            font-weight: 600;
            transition: background-color .15s ease, color .15s ease;
        }

        /* keep text readable */
        #eventPriority option {
            color: #212529;
        }

        /* ✅ Highlight overlay for selected date range */
        .fc .fc-highlight-range {
            background: rgba(255, 193, 7, .25) !important;
            /* light yellow */
            border: 1px solid rgba(255, 193, 7, .55) !important;
            border-radius: 6px;
        }
    </style>
@endpush

{{-- ================= SCRIPTS ================= --}}
@push('scripts')
<script>
    window.CALENDAR_USER_ID = {!! auth()->id() ? (int) auth()->id() : 'null' !!};
</script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
/* ===========================
   QUERY PARAMS (from dashboard)
=========================== */
function qs(name) {
    return new URLSearchParams(window.location.search).get(name);
}
const DASH_DATE     = qs('date');   // yyyy-mm-dd
const DASH_EVENT_ID = qs('event');  // event id

/* ===========================
   GLOBAL STATE
=========================== */
let projectCalendar = null;
let editingEventId = null;
let viewingEventOwnerId = null;

/* ===========================
   COLORS
=========================== */
const PRIORITY_COLORS = {
    Low: 'rgb(21, 255, 0)',
    Medium: 'rgb(221, 255, 0)',
    High: 'rgb(255, 106, 0)',
    Critical: 'red'
};

function priorityTextColor(priority) {
    if (priority === 'Low' || priority === 'Medium' || priority === 'High') return '#212529';
    return '#ffffff';
}

/* ===========================
   HELPERS
=========================== */
function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta?.content) return meta.content;
    const input = document.querySelector('#eventForm input[name="_token"]');
    return input?.value || '';
}

function isOwner(ownerId) {
    return String(ownerId) === String(window.CALENDAR_USER_ID);
}

function toast(msg, type = 'success') {
    if (window.Swal) {
        Swal.fire({ icon: type, title: msg, timer: 1600, showConfirmButton: false });
    } else {
        alert(msg);
    }
}

async function apiFetch(url, method, payload = null) {
    const res = await fetch(url, {
        method,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: payload ? JSON.stringify(payload) : null
    });

    const data = await res.json().catch(() => ({}));
    if (!res.ok) throw new Error(data.message || 'Request failed');
    return data;
}

/* ===========================
   FORCE EVENT COLORS
=========================== */
function paintCalendarEvent(el, priority) {
    if (!el) return;

    const bg = PRIORITY_COLORS[priority] || PRIORITY_COLORS.Medium;
    const fg = priorityTextColor(priority);

    el.style.backgroundColor = bg;
    el.style.borderColor = bg;

    el.style.setProperty('--fc-event-bg-color', bg);
    el.style.setProperty('--fc-event-border-color', bg);
    el.style.setProperty('--fc-event-text-color', fg);

    el.style.color = fg;

    const nodes = el.querySelectorAll(
        '.fc-event-title, .fc-event-time, .fc-event-main, .fc-event-main-frame, .fc-event-title-container, a, span, div'
    );
    nodes.forEach(n => n.style.color = fg);

    el.style.fontWeight = '600';
}

/* ===========================
   FORM ELEMENTS
=========================== */
const form            = document.getElementById('eventForm');
const eventTitle      = document.getElementById('eventTitle');
const eventDescription= document.getElementById('eventDescription');
const eventDate       = document.getElementById('eventDate');
const eventEndDate    = document.getElementById('eventEndDate');
const eventType       = document.getElementById('eventType');
const eventLocation   = document.getElementById('eventLocation');
const eventVisibility = document.getElementById('eventVisibility');
const eventPriority   = document.getElementById('eventPriority');

const modal     = document.getElementById('addEventModal');
const titleEl   = document.getElementById('addEventModalTitle');
const submitBtn = document.getElementById('eventSubmitBtn');
const deleteBtn = document.getElementById('eventDeleteBtn');
const editBtn   = document.getElementById('eventEditBtn');
const cancelBtn = document.getElementById('eventCancelBtn');

function applyPrioritySelectBG(value) {
    const bg = PRIORITY_COLORS[value] || PRIORITY_COLORS.Medium;
    const fg = priorityTextColor(value || 'Medium');
    eventPriority.style.backgroundColor = bg;
    eventPriority.style.color = fg;
    eventPriority.style.borderColor = bg;
}

/* ===========================
   MODE
=========================== */
function setFormDisabled(disabled) {
    form.querySelectorAll('input, textarea, select').forEach(el => el.disabled = disabled);
}

function setMode(mode, canEdit = true) {
    editBtn.classList.add('d-none');
    deleteBtn.classList.add('d-none');
    submitBtn.classList.remove('d-none');

    if (mode === 'add') {
        setFormDisabled(false);
        titleEl.textContent = 'Add New Project Event';
        submitBtn.innerHTML = '<i class="bi bi-save"></i> Add Event';
        cancelBtn.innerHTML = '<i class="bi bi-x-lg"></i> Cancel';
    }

    if (mode === 'view') {
        setFormDisabled(true);
        titleEl.textContent = 'Project Event Details';
        submitBtn.classList.add('d-none');
        if (canEdit) editBtn.classList.remove('d-none');
        cancelBtn.innerHTML = '<i class="bi bi-x-lg"></i> Close';
    }

    if (mode === 'edit') {
        setFormDisabled(false);
        titleEl.textContent = 'Edit Project Event';
        submitBtn.innerHTML = '<i class="bi bi-save"></i> Update Event';
        deleteBtn.classList.remove('d-none');
        cancelBtn.innerHTML = '<i class="bi bi-x-lg"></i> Cancel';
    }
}

/* ===========================
   MODAL
=========================== */
function openAddEventModal(dateStr = '') {
    editingEventId = null;
    viewingEventOwnerId = null;

    form.reset();
    eventDate.value = dateStr;
    eventPriority.value = 'Medium';

    applyPrioritySelectBG('Medium');
    setMode('add');
    modal.classList.add('show');
}

function openEditEventModal(fcEvent) {
    editingEventId = fcEvent.id;

    const p = fcEvent.extendedProps || {};
    viewingEventOwnerId = p.created_by;

    eventTitle.value = fcEvent.title || '';
    eventDescription.value = p.description || '';
    eventDate.value = p.range_start || (fcEvent.startStr ? fcEvent.startStr.substring(0, 10) : '');
    eventEndDate.value = (p.range_end && p.range_end !== p.range_start) ? p.range_end : '';
    eventType.value = p.type || '';
    eventLocation.value = p.location || '';
    eventVisibility.value = p.visibility || 'public';
    eventPriority.value = p.priority || 'Medium';

    applyPrioritySelectBG(eventPriority.value);

    setMode('view', isOwner(viewingEventOwnerId));
    modal.classList.add('show');
}

function enterEditMode() {
    if (!isOwner(viewingEventOwnerId)) return;
    setMode('edit');
    applyPrioritySelectBG(eventPriority.value);
}

function closeAddEventModal() {
    modal.classList.remove('show');
    editingEventId = null;
    viewingEventOwnerId = null;
    setFormDisabled(false);
}

/* ===========================
   CRUD
=========================== */
function getPayload() {
    if (!eventTitle.value.trim()) throw new Error('Project Title is required.');
    if (!eventDate.value) throw new Error('Date is required.');
    if (!eventType.value) throw new Error('Project Type is required.');

    return {
        title: eventTitle.value.trim(),
        description: eventDescription.value?.trim() || null,
        start_date: eventDate.value,
        end_date: eventEndDate.value || null,
        type: eventType.value,
        location: eventLocation.value?.trim() || null,
        visibility: eventVisibility.value || 'public',
        priority: eventPriority.value || 'Medium'
    };
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {
        const payload = getPayload();

        if (!editingEventId) {
            await apiFetch(`{{ route('calendar.events.store') }}`, 'POST', payload);
            toast('Event created');
        } else {
            if (!isOwner(viewingEventOwnerId)) throw new Error('You do not own this event.');
            await apiFetch(`/calendar/events/${editingEventId}`, 'PUT', payload);
            toast('Event updated');
        }

        closeAddEventModal();
        projectCalendar.refetchEvents();
    } catch (err) {
        toast(err.message || 'Something went wrong', 'error');
    }
});

async function deleteEventFromEdit() {
    if (!editingEventId) return;
    if (!isOwner(viewingEventOwnerId)) {
        toast('You do not own this event.', 'error');
        return;
    }

    const go = async () => {
        try {
            await apiFetch(`/calendar/events/${editingEventId}`, 'DELETE');
            toast('Event deleted');
            closeAddEventModal();
            projectCalendar.refetchEvents();
        } catch (err) {
            toast(err.message || 'Delete failed', 'error');
        }
    };

    if (window.Swal) {
        const res = await Swal.fire({
            icon: 'warning',
            title: 'Delete this event?',
            text: 'This cannot be undone.',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete'
        });
        if (res.isConfirmed) go();
    } else {
        if (confirm('Delete this event?')) go();
    }
}

eventPriority.addEventListener('change', () => {
    applyPrioritySelectBG(eventPriority.value);
});

/* ===========================
   DASHBOARD TARGET LOGIC
   - jump to date
   - flash event
   - auto-open modal (optional)
=========================== */
let dashOpenedOnce = false;

function flashEventElementById(eventId) {
    // find event element currently in DOM
    const el = document.querySelector(`.fc-event[data-event-id="${eventId}"]`);
    if (!el) return false;

    el.classList.add('fc-flash-highlight');
    setTimeout(() => el.classList.remove('fc-flash-highlight'), 2600);
    return true;
}

function tryOpenDashEventOnce() {
    if (dashOpenedOnce) return;
    if (!DASH_EVENT_ID) return;

    const ev = projectCalendar.getEventById(String(DASH_EVENT_ID));
    if (!ev) return;

    dashOpenedOnce = true;

    // open modal
    openEditEventModal(ev);

    // flash highlight (might not be mounted yet, retry few times)
    let tries = 0;
    const t = setInterval(() => {
        tries++;
        const ok = flashEventElementById(DASH_EVENT_ID);
        if (ok || tries >= 10) clearInterval(t);
    }, 200);
}

/* ===========================
   CALENDAR INIT (CLEAN)
=========================== */
document.addEventListener('DOMContentLoaded', () => {
    const calEl = document.getElementById('calendar');
    if (!calEl) {
        console.error('Calendar container #calendar not found');
        return;
    }

    projectCalendar = new FullCalendar.Calendar(calEl, {
        initialView: 'dayGridMonth',
        selectable: true,

        // ✅ ONLY ONE source
        events: '{{ route('calendar.events.index') }}',

        dateClick: info => openAddEventModal(info.dateStr),
        eventClick: info => openEditEventModal(info.event),

        viewDidMount: function() {
            if (DASH_DATE) projectCalendar.gotoDate(DASH_DATE);
        },

        eventDidMount: function(info) {
            // your priority colors
            const priority = info.event.extendedProps?.priority || 'Medium';
            paintCalendarEvent(info.el, priority);

            // help the DOM query find it reliably
            info.el.setAttribute('data-event-id', String(info.event.id));

            // if coming from dashboard, open & flash once it exists
            if (DASH_EVENT_ID) {
                // slight delay so DOM settles
                setTimeout(() => tryOpenDashEventOnce(), 50);
            }
        }
    });

    projectCalendar.render();

    if (DASH_DATE) projectCalendar.gotoDate(DASH_DATE);
});
</script>
@endpush
