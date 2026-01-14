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

{{-- ADD / VIEW / EDIT EVENT MODAL --}}
<div id="addEventModal" class="calendar-modal-overlay">
    <div class="calendar-modal-container">
        <div class="calendar-modal-content">

            <div class="calendar-modal-header">
                <h3 class="calendar-modal-title" id="addEventModalTitle">
                    Add New Project Event
                </h3>
                <button class="calendar-close-btn"
                        type="button"
                        onclick="closeAddEventModal()">
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
                    <textarea id="eventDescription"
                              class="calendar-form-input calendar-form-textarea"></textarea>
                </div>

                <div class="calendar-form-group">
                    <label class="calendar-form-label">Date *</label>
                    <div class="calendar-input-wrapper">
                        <input type="date"
                               id="eventDate"
                               class="calendar-form-input"
                               required>
                        <span class="calendar-icon">
                            <i class="bi bi-calendar-event"></i>
                        </span>
                    </div>
                </div>

                <div class="calendar-form-group">
                    <label class="calendar-form-label">End Date (Optional)</label>
                    <div class="calendar-input-wrapper">
                        <input type="date"
                               id="eventEndDate"
                               class="calendar-form-input">
                        <span class="calendar-icon">
                            <i class="bi bi-calendar-event"></i>
                        </span>
                    </div>
                </div>

                <div class="calendar-form-group">
                    <label class="calendar-form-label">Project Type *</label>
                    <select id="eventType"
                            class="calendar-form-input"
                            required>
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
                    <input type="text"
                           id="eventLocation"
                           class="calendar-form-input">
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

                {{-- BUTTON ROW --}}
                <div class="calendar-btn-row mt-3">

                    {{-- VIEW MODE --}}
                    <button type="button"
                            class="btn btn-primary me-auto d-none"
                            id="eventEditBtn"
                            onclick="enterEditMode()">
                        <i class="bi bi-pencil"></i> Edit
                    </button>

                    {{-- EDIT MODE --}}
                    <button type="button"
                            class="btn btn-danger me-auto d-none"
                            id="eventDeleteBtn"
                            onclick="deleteEventFromEdit()">
                        <i class="bi bi-trash"></i> Delete
                    </button>

                    <button type="button"
                            class="btn btn-secondary"
                            id="eventCancelBtn"
                            onclick="closeAddEventModal()">
                        <i class="bi bi-x-lg"></i> Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary"
                            id="eventSubmitBtn">
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
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css">

<style>
.calendar-page #calendar { min-height: 400px; }

.calendar-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.4);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1050;
}

.calendar-modal-overlay.show { display: flex; }

.calendar-modal-container { max-width: 540px; width: 100%; }

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

.calendar-form-group { margin-bottom: .75rem; }
.calendar-form-label { font-weight: 600; margin-bottom: .35rem; display:block; }

.calendar-form-input,
.calendar-form-textarea {
    width: 100%;
    padding: .45rem .6rem;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}

.calendar-form-textarea { min-height: 80px; }

.calendar-input-wrapper { position: relative; }
.calendar-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}

.calendar-btn-row { display: flex; gap: .5rem; }

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
    box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25);
}

/* Disabled (VIEW MODE) */
.calendar-modal-content input:disabled,
.calendar-modal-content textarea:disabled,
.calendar-modal-content select:disabled {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    cursor: not-allowed;
}

</style>
@endpush

{{-- ================= SCRIPTS ================= --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
let projectCalendar = null;
let editingEventId = null;

/* ---------- MODE HANDLING ---------- */
function setFormDisabled(disabled) {
    document.querySelectorAll('#eventForm input, #eventForm textarea, #eventForm select')
        .forEach(el => el.disabled = disabled);
}

function setMode(mode) {
    const title = document.getElementById('addEventModalTitle');
    const submit = document.getElementById('eventSubmitBtn');
    const del = document.getElementById('eventDeleteBtn');
    const edit = document.getElementById('eventEditBtn');
    const cancel = document.getElementById('eventCancelBtn');

    edit.classList.add('d-none');
    del.classList.add('d-none');
    submit.classList.remove('d-none');

    if (mode === 'add') {
        setFormDisabled(false);
        title.textContent = 'Add New Project Event';
        submit.innerHTML = '<i class="bi bi-save"></i> Add Event';
        cancel.innerHTML = '<i class="bi bi-x-lg"></i> Cancel';
    }

    if (mode === 'view') {
        setFormDisabled(true);
        title.textContent = 'Project Event Details';
        submit.classList.add('d-none');
        edit.classList.remove('d-none');
        cancel.innerHTML = '<i class="bi bi-x-lg"></i> Close';
    }

    if (mode === 'edit') {
        setFormDisabled(false);
        title.textContent = 'Edit Project Event';
        submit.innerHTML = '<i class="bi bi-save"></i> Update Event';
        del.classList.remove('d-none');
        cancel.innerHTML = '<i class="bi bi-x-lg"></i> Cancel';
    }
}

/* ---------- MODAL ---------- */
function openAddEventModal(dateStr = '') {
    editingEventId = null;
    document.getElementById('eventForm').reset();
    document.getElementById('eventDate').value = dateStr;
    setMode('add');
    document.getElementById('addEventModal').classList.add('show');
}

function openEditEventModal(event) {
    editingEventId = event.id;
    const p = event.extendedProps || {};

    eventTitle.value = event.title || '';
    eventDescription.value = p.description || '';
    eventDate.value = event.startStr?.substring(0,10) || '';
    eventEndDate.value = event.endStr?.substring(0,10) || '';
    eventType.value = p.type || '';
    eventLocation.value = p.location || '';
    eventVisibility.value = p.visibility || 'public';
    eventPriority.value = p.priority || 'Medium';

    setMode('view');
    document.getElementById('addEventModal').classList.add('show');
}

function enterEditMode() { setMode('edit'); }
function closeAddEventModal() {
    document.getElementById('addEventModal').classList.remove('show');
    editingEventId = null;
    setFormDisabled(false);
}

/* ---------- CALENDAR ---------- */
document.addEventListener('DOMContentLoaded', () => {
    projectCalendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        selectable: true,
        events: '{{ route('calendar.events.index') }}',
        dateClick: info => openAddEventModal(info.dateStr),
        eventClick: info => openEditEventModal(info.event)
    });
    projectCalendar.render();
});
</script>
@endpush
