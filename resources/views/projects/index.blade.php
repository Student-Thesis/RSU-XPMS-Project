@extends('layouts.app')

@section('content')
    @php
        $canEditYesNo = auth()->check() && auth()->user()->department_id == 1;
    @endphp

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0">Project Proposals</h3>
                </div>
                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('projects.create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add Proposal
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    {{-- FILTERS --}}
                    <form method="GET" action="{{ route('projects') }}" class="row g-3 align-items-end mb-3"
                        id="filterForm">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Search</label>
                            <input type="text" name="q" id="searchInput" value="{{ $q ?? '' }}"
                                class="form-control form-control-sm" placeholder="Search project...">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Filter by College/Campus</label>
                            <select name="college" class="form-select form-select-sm">
                                <option value="All" {{ ($college ?? '') === 'All' ? 'selected' : '' }}>All</option>
                                @foreach (['CAS', 'CBA', 'CET', 'CAFES', 'CCMADI', 'CED', 'GEPS', 'CALATRAVA CAMPUS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS', 'SAN ANDRES CAMPUS', 'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS', 'CAJIDIOCAN CAMPUS', 'SAN FERNANDO CAMPUS'] as $opt)
                                    <option value="{{ $opt }}" {{ ($college ?? '') === $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Filter by Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="All" {{ ($status ?? '') === 'All' ? 'selected' : '' }}>All</option>
                                <option value="Ongoing" {{ ($status ?? '') === 'Ongoing' ? 'selected' : '' }}>Ongoing
                                </option>
                                <option value="Completed" {{ ($status ?? '') === 'Completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="Cancelled" {{ ($status ?? '') === 'Cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>
                        {{-- No submit button – auto-submit via JS --}}
                    </form>

                    {{-- TABLE --}}
                    <div class="table-responsive">
                        <table id="proposalTable"
                            class="table table-bordered table-striped table-hover table-sm align-middle text-center text-nowrap proposal-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Title</th>
                                     <th>Drive Link</th>
                                    <th>Classification</th>
                                    <th>Leader</th>
                                    <th>Team Members</th>
                                    <th>College/Campus</th>
                                    <th>Target Agenda</th>
                                    <th>In-House</th>
                                    <th>Revised</th>
                                    <th>NTP</th>
                                    <th>Endorsement</th>

                                    <th width="100px">Documents</th>
                                    <th width="115px">Program</th>
                                    <th width="115px">Project</th>
                                    <th>MOA/MOU</th>
                                    <th width="115px">Activity Design</th>

                                    <th>Budget</th>
                                    <th>Funds</th>
                                    <th>Expenditure</th>
                                    <th>Rate</th>
                                    <th>Partner</th>
                                    <th>Status</th>
                                    <th>Documentation</th>

                                    <th>Remarks</th>
                                   
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proposals as $proposal)
                                    @php
                                        $leader = $proposal->leader ?? '—';
                                        $college = $proposal->location ?? '—';
                                        $team = $proposal->team_members ?: '—';
                                        $agenda = $proposal->target_agenda ?: '—';
                                        $budget = number_format($proposal->approved_budget, 2);
                                    @endphp

                                    <tr data-id="{{ $proposal->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ $proposal->title }}</td>
  {{-- Drive Link --}}
                                        <td class="inline-cell" data-col="drive_link">
                                            @if ($proposal->drive_link && filter_var($proposal->drive_link, FILTER_VALIDATE_URL))
                                                <a href="{{ $proposal->drive_link }}" target="_blank"
                                                    class="small link-primary">
                                                    Open Link
                                                </a>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        {{-- Classification --}}
                                        <td>
                                            <input list="classifications" class="form-control form-control-sm inline-edit"
                                                data-col="classification" value="{{ $proposal->classification }}">
                                        </td>

                                        <td>{{ $leader }}</td>
                                        <td>{{ $team }}</td>
                                        <td>{{ $college }}</td>
                                        <td>{{ $agenda }}</td>

                                        {{-- 1. In-House --}}
                                        <td>
                                            <select class="form-select form-select-sm dropdown-yesno" data-col="in_house"
                                                data-label="In-House"
                                                data-url="{{ route('projects.inline-update', $proposal->id) }}"
                                                data-prev="{{ $proposal->in_house ? 1 : 0 }}"
                                                {{ $canEditYesNo ? '' : 'disabled' }}>
                                                <option value="0" {{ !$proposal->in_house ? 'selected' : '' }}>No
                                                </option>
                                                <option value="1" {{ $proposal->in_house ? 'selected' : '' }}>Yes
                                                </option>
                                            </select>
                                        </td>

                                        {{-- 2. Revised --}}
                                        <td>
                                            <select class="form-select form-select-sm dropdown-yesno"
                                                data-col="revised_proposal" data-label="Revised Proposal"
                                                data-url="{{ route('projects.inline-update', $proposal->id) }}"
                                                data-prev="{{ $proposal->revised_proposal ? 1 : 0 }}"
                                                {{ $canEditYesNo ? '' : 'disabled' }}>
                                                <option value="0"
                                                    {{ !$proposal->revised_proposal ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ $proposal->revised_proposal ? 'selected' : '' }}>
                                                    Yes</option>
                                            </select>
                                        </td>

                                        {{-- 3. NTP --}}
                                        <td>
                                            <select class="form-select form-select-sm dropdown-yesno" data-col="ntp"
                                                data-label="NTP"
                                                data-url="{{ route('projects.inline-update', $proposal->id) }}"
                                                data-prev="{{ $proposal->ntp ? 1 : 0 }}"
                                                {{ $canEditYesNo ? '' : 'disabled' }}>
                                                <option value="0" {{ !$proposal->ntp ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ $proposal->ntp ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </td>

                                        {{-- 4. Endorsement --}}
                                        <td>
                                            <select class="form-select form-select-sm dropdown-yesno" data-col="endorsement"
                                                data-label="Endorsement"
                                                data-url="{{ route('projects.inline-update', $proposal->id) }}"
                                                data-prev="{{ $proposal->endorsement ? 1 : 0 }}"
                                                {{ $canEditYesNo ? '' : 'disabled' }}>
                                                <option value="0" {{ !$proposal->endorsement ? 'selected' : '' }}>No
                                                </option>
                                                <option value="1" {{ $proposal->endorsement ? 'selected' : '' }}>Yes
                                                </option>
                                            </select>
                                        </td>

                                        {{-- 5. Documents --}}
                                        <td>
                                            <select class="form-select form-select-sm dropdown-yesno"
                                                data-col="proposal_documents" data-label="Proposal Documents"
                                                data-url="{{ route('projects.inline-update', $proposal->id) }}"
                                                data-prev="{{ $proposal->proposal_documents ? 1 : 0 }}"
                                                {{ $canEditYesNo ? '' : 'disabled' }}>
                                                <option value="0"
                                                    {{ !$proposal->proposal_documents ? 'selected' : '' }}>No</option>
                                                <option value="1"
                                                    {{ $proposal->proposal_documents ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </td>

                                        {{-- 6. Program --}}
                                        <td>
                                            <select class="form-select form-select-sm dropdown-yesno"
                                                data-col="program_proposal" data-label="Program Proposal"
                                                data-url="{{ route('projects.inline-update', $proposal->id) }}"
                                                data-prev="{{ $proposal->program_proposal ? 1 : 0 }}"
                                                {{ $canEditYesNo ? '' : 'disabled' }}>
                                                <option value="0"
                                                    {{ !$proposal->program_proposal ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ $proposal->program_proposal ? 'selected' : '' }}>
                                                    Yes</option>
                                            </select>
                                        </td>

                                        {{-- 7. Project --}}
                                        <td>
                                            <select class="form-select form-select-sm dropdown-yesno"
                                                data-col="project_proposal" data-label="Project Proposal"
                                                data-url="{{ route('projects.inline-update', $proposal->id) }}"
                                                data-prev="{{ $proposal->project_proposal ? 1 : 0 }}"
                                                {{ $canEditYesNo ? '' : 'disabled' }}>
                                                <option value="0"
                                                    {{ !$proposal->project_proposal ? 'selected' : '' }}>No</option>
                                                <option value="1"
                                                    {{ $proposal->project_proposal ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </td>

                                        {{-- 8. MOA/MOU --}}
                                      <td class="inline-cell" data-col="mou_path">
    @if (!empty($proposal->mou_path))
        <a href="{{ $basePath . '/' . ltrim($proposal->mou_path, '/') }}"
           target="_blank"
           class="link-primary text-decoration-none">
            📎 Attached File
        </a>
    @else
        —
    @endif
</td>


                                        {{-- 9. Activity Design --}}
                                        <td>
                                            <select class="form-select form-select-sm dropdown-yesno"
                                                data-col="activity_design" data-label="Activity Design"
                                                data-url="{{ route('projects.inline-update', $proposal->id) }}"
                                                data-prev="{{ $proposal->activity_design ? 1 : 0 }}"
                                                {{ $canEditYesNo ? '' : 'disabled' }}>
                                                <option value="0"
                                                    {{ !$proposal->activity_design ? 'selected' : '' }}>No</option>
                                                <option value="1" {{ $proposal->activity_design ? 'selected' : '' }}>
                                                    Yes</option>
                                            </select>
                                        </td>

                                        {{-- Budget --}}
                                        <td>{{ $budget }}</td>

                                        <td contenteditable="true" class="inline-cell text-start"
                                            data-col="source_of_funds">
                                            {{ $proposal->source_of_funds ?? '—' }}
                                        </td>

                                        <td contenteditable="true" class="inline-cell text-end" data-col="expenditure">
                                            {{ $proposal->expenditure ?? '—' }}
                                        </td>

                                        <td contenteditable="true" class="inline-cell text-end"
                                            data-col="fund_utilization_rate">
                                            {{ $proposal->fund_utilization_rate ?? '—' }}
                                        </td>

                                        <td>{{ $proposal->partner ?? '—' }}</td>

                                        <td>
                                            @php
                                                $status = $proposal->status ?? '—';
                                                $color = match ($status) {
                                                    'Pending' => 'text-warning fw-semibold',
                                                    'Approved' => 'text-success fw-semibold',
                                                    'Ongoing' => 'text-primary fw-semibold',
                                                    'Cancelled' => 'text-danger fw-semibold',
                                                    'Completed' => 'text-success fw-semibold',
                                                    default => 'text-muted',
                                                };
                                            @endphp
                                            <span class="{{ $color }}">{{ $status }}</span>
                                        </td>

                                    <td class="text-start">
    @if (!empty($proposal->documentation_report))
        <a href="{{ $basePath . '/' . ltrim($proposal->documentation_report, '/') }}"
           target="_blank"
           class="text-decoration-none">
            📎 Attached File
        </a>
    @else
        —
    @endif
</td>



                                        <td contenteditable="true" class="inline-cell text-start" data-col="remarks">
                                            {{ $proposal->remarks ?? '—' }}
                                        </td>

                                      

                                        {{-- Actions --}}
                                        <td>
                                            <a href="{{ route('projects.edit', $proposal->id) }}"
                                                class="btn btn-warning btn-xs">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <button type="button" class="btn btn-danger btn-xs btn-delete"
                                                data-id="{{ $proposal->id }}"
                                                data-action="{{ route('projects.destroy', $proposal->id) }}">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <form id="delete-form-{{ $proposal->id }}"
                                                action="{{ route('projects.destroy', $proposal->id) }}" method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="30" class="text-muted py-4">No proposals found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- classification datalist --}}
                    <datalist id="classifications">
                        <option value="Program">
                        <option value="Project">
                    </datalist>

                </div>
            </div>
        </div>
    </div>

    {{-- ====== PAGE STYLES ====== --}}
    <style>
        .proposal-table td,
        .proposal-table th {
            padding: .35rem .5rem !important;
        }

        .inline-cell {
            cursor: text;
        }

        .dropdown-yesno {
            min-width: 70px;
            font-weight: 600;
        }

        /* Selected value = YES (1) */
        .dropdown-yesno.yes {
            background-color: #d1e7dd !important;
            /* green-ish */
            color: #0f5132 !important;
            border-color: #0f5132 !important;
        }

        /* Selected value = NO (0) */
        .dropdown-yesno.no {
            background-color: #f8d7da !important;
            /* red-ish */
            color: #842029 !important;
            border-color: #842029 !important;
        }

        /* Options inside the dropdown */
        .dropdown-yesno option[value="0"] {
            background-color: #f8d7da;
            color: #842029;
        }

        .dropdown-yesno option[value="1"] {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .btn-xs {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 2px 6px;
            font-size: 0.75rem;
            line-height: 1;
            border-radius: 4px;
        }
    </style>

    {{-- SweetAlert2 (if not already loaded in layout) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function getCsrfToken() {
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta) return meta.getAttribute('content');

            const input = document.querySelector('input[name="_token"]');
            if (input) return input.value;

            console.warn('CSRF token not found in meta or input[name="_token"].');
            return '';
        }

        const CSRF_TOKEN = getCsrfToken();

        function setYesNoColor(el) {
            el.classList.remove('yes', 'no');
            const isYes = el.value === '1';
            el.classList.add(isYes ? 'yes' : 'no');
        }

        async function handleYesNoChange(el) {
            if (typeof Swal === 'undefined') {
                console.warn('SweetAlert2 (Swal) is not loaded.');
                return;
            }

            const row = el.closest('tr');
            const id = row.dataset.id;
            const url = el.dataset.url;
            const column = el.dataset.col;
            const label = el.dataset.label || column;

            const newValue = el.value;
            const newLabel = newValue === '1' ? 'Yes' : 'No';
            const oldValue = el.dataset.prev;

            const result = await Swal.fire({
                title: 'Update field?',
                text: `Set "${label}" to ${newLabel}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            });

            if (!result.isConfirmed) {
                el.value = oldValue;
                setYesNoColor(el);
                return;
            }

            const formData = new FormData();
            formData.append('column', column);
            formData.append('value', newValue);

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const contentType = response.headers.get('content-type') || '';
                let data = {};

                if (!response.ok) {
                    const text = await response.text();
                    console.error('HTTP error:', response.status, text);
                    throw new Error('Network error (' + response.status + ')');
                }

                if (contentType.includes('application/json')) {
                    data = await response.json();
                }

                if (data.success === false || data.ok === false) {
                    throw new Error(data.message || 'Update failed.');
                }

                el.dataset.prev = newValue;
                setYesNoColor(el);

                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: data.message || 'Field updated successfully.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            } catch (err) {
                console.error('Update failed:', err);

                Swal.fire({
                    icon: 'error',
                    title: 'Update failed',
                    text: err.message || 'Could not save changes.',
                });

                el.value = oldValue;
                setYesNoColor(el);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const searchInput = document.getElementById('searchInput');
            const selects = form ? form.querySelectorAll('select[name="college"], select[name="status"]') : [];
            let searchTimeout = null;

            // Init Yes/No dropdowns
            document.querySelectorAll('.dropdown-yesno').forEach(el => {
                if (!el.dataset.prev) {
                    el.dataset.prev = el.value;
                }
                setYesNoColor(el);

                if (!el.disabled) {
                    el.addEventListener('change', function() {
                        handleYesNoChange(this);
                    });
                }
            });

            // Delete with SweetAlert
            document.addEventListener('click', async e => {
                const btn = e.target.closest('.btn-delete');
                if (!btn) return;

                const id = btn.dataset.id;
                const delForm = document.getElementById(`delete-form-${id}`);

                if (typeof Swal === 'undefined') {
                    if (confirm('Delete proposal? This cannot be undone.')) {
                        delForm.submit();
                    }
                    return;
                }

                const ok = await Swal.fire({
                    title: 'Delete proposal?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                }).then(r => r.isConfirmed);

                if (ok) delForm.submit();
            });

            // Debounced search
            if (searchInput && form) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        form.submit();
                    }, 500);
                });

                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.submit();
                    }
                });
            }

            // Auto-submit filters
            selects.forEach(function(sel) {
                sel.addEventListener('change', function() {
                    form.submit();
                });
            });
        });
    </script>
@endsection
