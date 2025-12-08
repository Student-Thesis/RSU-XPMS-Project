@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')

        @php
            $canEditYesNo = auth()->check() && auth()->user()->department_id == 1;
        @endphp

        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title d-flex align-items-center justify-content-between gap-2 flex-wrap">
                            <h3 class="m-0">Project Proposals</h3>

                            {{-- Go to full-page create form --}}
                            <a href="{{ route('projects.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add Proposal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filters + Search -->
                <form method="GET" action="{{ route('projects') }}" class="row align-items-end g-3 mb-3" id="filterForm">
                    <div class="col-md-3">
                        <label><strong>Search:</strong></label>
                        <input type="text" name="q" id="searchInput" value="{{ $q ?? '' }}"
                            class="form-control" placeholder="Search project...">
                    </div>

                    <div class="col-md-3">
                        <label><strong>Filter by College/Campus:</strong></label>
                        <select name="college" class="form-control">
                            <option value="All" {{ ($college ?? '') === 'All' ? 'selected' : '' }}>All</option>
                            @foreach (['CAS', 'CBA', 'CET', 'CAFES', 'CCMADI', 'CED', 'GEPS', 'CALATRAVA CAMPUS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS', 'SAN ANDRES CAMPUS', 'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS', 'CAJIDIOCAN CAMPUS', 'SAN FERNANDO CAMPUS'] as $opt)
                                <option value="{{ $opt }}" {{ ($college ?? '') === $opt ? 'selected' : '' }}>
                                    {{ $opt }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label><strong>Filter by Status:</strong></label>
                        <select name="status" class="form-control">
                            <option value="All" {{ ($status ?? '') === 'All' ? 'selected' : '' }}>All</option>
                            <option value="Ongoing" {{ ($status ?? '') === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Completed" {{ ($status ?? '') === 'Completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="Cancelled" {{ ($status ?? '') === 'Cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                    {{-- No submit button – auto-submit via JS --}}
                </form>

                <div class="table-responsive mt-3">
                    <table id="proposalTable"
                        class="table table-bordered table-striped text-center align-middle proposal-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Classification</th>
                                <th>Leader</th>
                                <th>Team Members</th>
                                <th>College/Campus</th>
                                <th>Target Agenda</th>
                                <th>In-House</th>
                                <th>Revised</th>
                                <th>NTP</th>
                                <th>Endorsement</th>

                                <th>Documents</th>
                                <th>Program</th>
                                <th>Project</th>
                                <th>MOA/MOU</th>
                                <th>Activity Design</th>

                                <th>Budget</th>
                                <th>Funds</th>
                                <th>Expenditure</th>
                                <th>Rate</th>
                                <th>Partner</th>
                                <th>Status</th>
                                <th>Documentation</th>

                                <th>Remarks</th>
                                <th>Drive Link</th>
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
                                    $code =
                                        optional($proposal->created_at)->format('Y') .
                                        '-' .
                                        str_pad($loop->iteration, 3, '0', STR_PAD_LEFT);
                                @endphp

                                <tr data-id="{{ $proposal->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $proposal->title }}</td>

                                    <td>
                                        <input list="classifications" class="form-control inline-edit"
                                            data-col="classification" value="{{ $proposal->classification }}">
                                        <datalist id="classifications">
                                            <option value="Program">
                                            <option value="Project">
                                        </datalist>
                                    </td>

                                    <td>{{ $leader }}</td>
                                    <td>{{ $team }}</td>
                                    <td>{{ $college }}</td>
                                    <td>{{ $agenda }}</td>

                                    {{-- 1. In-House --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->in_house ? 'yes' : 'no' }}"
                                            data-col="in_house" onchange="updateDropdownColor(this)"
                                            {{ $canEditYesNo ? '' : 'disabled' }}>
                                            <option {{ !$proposal->in_house ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->in_house ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- 2. Revised --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->revised_proposal ? 'yes' : 'no' }}"
                                            data-col="revised_proposal" onchange="updateDropdownColor(this)"
                                            {{ $canEditYesNo ? '' : 'disabled' }}>
                                            <option {{ !$proposal->revised_proposal ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->revised_proposal ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- 3. NTP --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->ntp ? 'yes' : 'no' }}" data-col="ntp"
                                            onchange="updateDropdownColor(this)" {{ $canEditYesNo ? '' : 'disabled' }}>
                                            <option {{ !$proposal->ntp ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->ntp ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- 4. Endorsement --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->endorsement ? 'yes' : 'no' }}"
                                            data-col="endorsement" onchange="updateDropdownColor(this)"
                                            {{ $canEditYesNo ? '' : 'disabled' }}>
                                            <option {{ !$proposal->endorsement ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->endorsement ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- 5. Documents --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->proposal_documents ? 'yes' : 'no' }}"
                                            data-col="proposal_documents" onchange="updateDropdownColor(this)"
                                            {{ $canEditYesNo ? '' : 'disabled' }}>
                                            <option {{ !$proposal->proposal_documents ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->proposal_documents ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- 6. Program --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->program_proposal ? 'yes' : 'no' }}"
                                            data-col="program_proposal" onchange="updateDropdownColor(this)"
                                            {{ $canEditYesNo ? '' : 'disabled' }}>
                                            <option {{ !$proposal->program_proposal ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->program_proposal ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- 7. Project --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->project_proposal ? 'yes' : 'no' }}"
                                            data-col="project_proposal" onchange="updateDropdownColor(this)"
                                            {{ $canEditYesNo ? '' : 'disabled' }}>
                                            <option {{ !$proposal->project_proposal ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->project_proposal ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- 8. MOA/MOU --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->moa_mou ? 'yes' : 'no' }}"
                                            data-col="moa_mou" onchange="updateDropdownColor(this)"
                                            {{ $canEditYesNo ? '' : 'disabled' }}>
                                            <option {{ !$proposal->moa_mou ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->moa_mou ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- 9. Activity Design --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->activity_design ? 'yes' : 'no' }}"
                                            data-col="activity_design" onchange="updateDropdownColor(this)"
                                            {{ $canEditYesNo ? '' : 'disabled' }}>
                                            <option {{ !$proposal->activity_design ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->activity_design ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    <td>{{ $budget }}</td>

                                    <td contenteditable="true" class="inline-cell" data-col="source_of_funds">
                                        {{ $proposal->source_of_funds ?? '—' }}
                                    </td>

                                    <td contenteditable="true" class="inline-cell" data-col="expenditure">
                                        {{ $proposal->expenditure ?? '—' }}
                                    </td>

                                    <td contenteditable="true" class="inline-cell" data-col="fund_utilization_rate">
                                        {{ $proposal->fund_utilization_rate ?? '—' }}
                                    </td>

                                    <td>{{ $proposal->partner ?? '—' }}</td>

                                    <td>
                                        @php
                                            $status = $proposal->status ?? '—';

                                            $color = match ($status) {
                                                'Pending'   => 'text-danger fw-bold',
                                                'Approved'  => 'text-success fw-bold', // green
                                                'Ongoing'   => 'text-warning fw-bold', // orange
                                                'Cancelled' => 'text-danger fw-bold', // red
                                                default     => 'text-success',        // default
                                            };
                                        @endphp

                                        <span class="{{ $color }}">{{ $status }}</span>
                                    </td>

                                    <td contenteditable="true" class="inline-cell" data-col="documentation_report">
                                        {{ $proposal->documentation_report ?? '—' }}
                                    </td>

                                    <td contenteditable="true" class="inline-cell" data-col="remarks">
                                        {{ $proposal->remarks ?? '—' }}
                                    </td>

                                    <td contenteditable="true" class="inline-cell" data-col="drive_link">
                                        {{ $proposal->moa_link ?? '—' }}
                                    </td>

                                    <td>
                                        <a href="{{ route('projects.edit', $proposal->id) }}"
                                            class="btn btn-warning btn-xs p-1 me-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-xs p-1 btn-delete"
                                            data-id="{{ $proposal->id }}"
                                            data-action="{{ route('projects.destroy', $proposal->id) }}">
                                            <i class="fa fa-trash"></i>
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
                                    <td colspan="30" class="text-muted">No proposals found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ====== PAGE STYLES (all in one place) ====== --}}
    <style>
        /* Table layout: auto-size based on content */
        #proposalTable,
        .proposal-table {
            table-layout: auto !important;
            width: auto;
            min-width: 100%;
        }

        #proposalTable th,
        #proposalTable td {
            white-space: nowrap;
        }

        /* Compact table cells */
        .table td {
            padding: 4px 6px !important;
            vertical-align: middle !important;
        }

        /* Yes / No dropdown colors */
        .dropdown-yesno.yes {
            background: #e7f7ef;
            color: #1f7a4a;
        }

        .dropdown-yesno.no {
            background: #fdecea;
            color: #b42318;
        }

        /* Status dropdown sizing (if you use select somewhere) */
        .status-select {
            min-width: 120px !important;
            width: auto !important;
            display: inline-block !important;
            padding-right: 24px;
        }

        .status-ongoing {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-select option:checked {
            font-weight: bold;
        }
    </style>

    {{-- ====== PAGE SCRIPTS (all in one place) ====== --}}
    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function updateDropdownColor(el) {
            el.classList.remove('yes', 'no');
            el.classList.add(el.value.toLowerCase() === 'yes' ? 'yes' : 'no');
        }

        document.addEventListener('click', async e => {
            const btn = e.target.closest('.btn-delete');
            if (!btn) return;

            const id = btn.dataset.id;
            const form = document.getElementById(`delete-form-${id}`);

            const ok = await Swal.fire({
                title: 'Delete proposal?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
            }).then(r => r.isConfirmed);

            if (ok) form.submit();
        });

        // Auto-submit filters
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            if (!form) return;

            const searchInput = document.getElementById('searchInput');
            const selects = form.querySelectorAll('select[name="college"], select[name="status"]');
            let searchTimeout = null;

            // Debounced search submit
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        form.submit();
                    }, 500);
                });

                // Submit on Enter
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.submit();
                    }
                });
            }

            // Submit on dropdown change
            selects.forEach(function(sel) {
                sel.addEventListener('change', function() {
                    form.submit();
                });
            });
        });
    </script>
@endsection
