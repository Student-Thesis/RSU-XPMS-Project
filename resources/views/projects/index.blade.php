@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')

        <!-- Main Content -->
        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h3>2025 Extension Project Proposals</h3>
                        </div>
                    </div>
                </div>

                <!-- Filters + Search -->
                <form method="GET" action="{{ route('projects') }}" class="row align-items-end g-3 mb-3">
                    <div class="col-md-3">
                        <label><strong>Search:</strong></label>
                        <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control"
                            placeholder="Search anything...">
                    </div>

                    <div class="col-md-3">
                        <label><strong>Filter by College/Campus:</strong></label>
                        <select name="college" class="form-control">
                            <option value="All" {{ ($college ?? '') === 'All' ? 'selected' : '' }}>All</option>
                            <option value="CAS" {{ ($college ?? '') === 'CAS' ? 'selected' : '' }}>CAS</option>
                            <option value="CBA" {{ ($college ?? '') === 'CBA' ? 'selected' : '' }}>CBA</option>
                            <option value="CET" {{ ($college ?? '') === 'CET' ? 'selected' : '' }}>CET</option>
                            <option value="CAFES" {{ ($college ?? '') === 'CAFES' ? 'selected' : '' }}>CAFES</option>
                            <option value="CCMADI" {{ ($college ?? '') === 'CCMADI' ? 'selected' : '' }}>CCMADI</option>
                            <option value="CED" {{ ($college ?? '') === 'CED' ? 'selected' : '' }}>CED</option>
                            <option value="GEPS" {{ ($college ?? '') === 'GEPS' ? 'selected' : '' }}>GEPS</option>
                            <option value="CALATRAVA CAMPUS"
                                {{ ($college ?? '') === 'CALATRAVA CAMPUS' ? 'selected' : '' }}>CALATRAVA CAMPUS</option>
                            <option value="STA. MARIA CAMPUS"
                                {{ ($college ?? '') === 'STA. MARIA CAMPUS' ? 'selected' : '' }}>STA. MARIA CAMPUS</option>
                            <option value="SANTA FE CAMPUS" {{ ($college ?? '') === 'SANTA FE CAMPUS' ? 'selected' : '' }}>
                                SANTA FE CAMPUS</option>
                            <option value="SAN ANDRES CAMPUS"
                                {{ ($college ?? '') === 'SAN ANDRES CAMPUS' ? 'selected' : '' }}>SAN ANDRES CAMPUS</option>
                            <option value="SAN AGUSTIN CAMPUS"
                                {{ ($college ?? '') === 'SAN AGUSTIN CAMPUS' ? 'selected' : '' }}>SAN AGUSTIN CAMPUS
                            </option>
                            <option value="ROMBLON CAMPUS" {{ ($college ?? '') === 'ROMBLON CAMPUS' ? 'selected' : '' }}>
                                ROMBLON CAMPUS</option>
                            <option value="CAJIDIOCAN CAMPUS"
                                {{ ($college ?? '') === 'CAJIDIOCAN CAMPUS' ? 'selected' : '' }}>CAJIDIOCAN CAMPUS</option>
                            <option value="SAN FERNANDO CAMPUS"
                                {{ ($college ?? '') === 'SAN FERNANDO CAMPUS' ? 'selected' : '' }}>SAN FERNANDO CAMPUS
                            </option>
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

                    <div class="col-md-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary w-100" style="margin-top: 26px;">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>
                </form>


                <div class="table-responsive" style="margin-top: 20px;">
                    <table id="proposalTable" class="table table-bordered table-striped text-center align-middle">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Classification</th>
                                <th>Program/Project Leader</th>
                                <th>Team Members</th>
                                <th>College/Campus</th>
                                <th>Target Agenda</th>
                                <th>In-House</th>
                                <th>Revised Proposal</th>
                                <th>NTP</th>
                                <th>Endorsement</th>
                                <th>Proposal Presentation</th>
                                <th>Proposal Documents</th>
                                <th>Program Proposal</th>
                                <th>Project Proposal</th>
                                <th>MOA/MOU</th>
                                <th>Activity Design</th>
                                <th>Certificate of Appearance</th>
                                <th>Attendance Sheet</th>
                                <th>Approved Budget</th>
                                <th>Source of Funds</th>
                                <th>Expenditure</th>
                                <th>Fund Utilization Rate</th>
                                <th>Partner</th>
                                <th>Status</th>
                                <th>Documentation Report</th>
                                <th>Code</th>
                                <th>Remarks</th>
                                <th>Drive Link</th>
                                <th style="min-width:130px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proposals as $proposal)
                                @php
                                    $leader = $proposal->leader ?? '—';
                                    $collegeCampus = $proposal->location ?? '—';
                                    $team = $proposal->team_members ?: '—';
                                    $agenda = $proposal->target_agenda ?: '—';
                                    $approvedBudget = number_format($proposal->approved_budget, 2);
                                    $code =
                                        optional($proposal->created_at)->format('Y') .
                                        '-' .
                                        str_pad($loop->iteration, 3, '0', STR_PAD_LEFT);
                                @endphp

                                <tr data-id="{{ $proposal->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $proposal->title }}</td>

                                    <td>
                                        <input list="classification-list" class="form-control inline-edit"
                                            data-col="classification" value="{{ $proposal->classification }}"
                                            style="min-width:110px;max-width:140px;display:inline-block;" />
                                        <datalist id="classification-list">
                                            <option value="Program">
                                            <option value="Project">
                                        </datalist>
                                    </td>

                                    <td>{{ $leader }}</td>
                                    <td>{{ $team }}</td>
                                    <td>{{ $collegeCampus }}</td>
                                    <td>{{ $agenda }}</td>

                                    {{-- YES/NO fields --}}
                                    @foreach (['in_house', 'revised_proposal', 'ntp', 'endorsement', 'proposal_presentation', 'proposal_documents', 'program_proposal', 'project_proposal', 'moa_mou', 'activity_design', 'certificate_of_appearance', 'attendance_sheet'] as $field)
                                        <td>
                                            <select class="dropdown-yesno {{ $proposal->$field ? 'yes' : 'no' }}"
                                                data-col="{{ $field }}" onchange="updateDropdownColor(this)">
                                                <option {{ !$proposal->$field ? 'selected' : '' }}>No</option>
                                                <option {{ $proposal->$field ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </td>
                                    @endforeach

                                    <td>{{ $approvedBudget }}</td>
                                    <td contenteditable="true" class="inline-cell" data-col="source_of_funds">
                                        {{ $proposal->source_of_funds ?? '—' }}</td>
                                    <td contenteditable="true" class="inline-cell" data-col="expenditure">
                                        {{ $proposal->expenditure ?? '—' }}</td>
                                    <td contenteditable="true" class="inline-cell" data-col="fund_utilization_rate">
                                        {{ $proposal->fund_utilization_rate ?? '—' }}</td>
                                    <td>{{ $proposal->partner ?: '—' }}</td>

                                    <td>
                                        <select class="form-control inline-select" data-col="status">
                                            @foreach (['Ongoing', 'Completed', 'Cancelled'] as $st)
                                                <option value="{{ $st }}"
                                                    {{ $proposal->status === $st ? 'selected' : '' }}>{{ $st }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td contenteditable="true" class="inline-cell" data-col="documentation_report">
                                        {{ $proposal->documentation_report ?? '—' }}</td>
                                    <td contenteditable="true" class="inline-cell" data-col="code">
                                        {{ $proposal->code ?? $code }}</td>
                                    <td contenteditable="true" class="inline-cell" data-col="remarks">
                                        {{ $proposal->remarks ?? '—' }}</td>
                                    <td contenteditable="true" class="inline-cell" data-col="drive_link">
                                        {{ $proposal->drive_link ?? '—' }}</td>

                                    {{-- ✅ Properly aligned Actions cell --}}
                                  <td class="text-nowrap" style="padding: 2px 4px; vertical-align: middle;">
    <a href="{{ route('projects.edit', $proposal->id) }}"
        class="btn btn-warning btn-xs me-1 p-1" style="font-size: 12px; line-height: 1;">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" class="btn btn-danger btn-xs p-1 btn-delete"
        data-id="{{ $proposal->id }}"
        data-action="{{ route('projects.destroy', $proposal->id) }}"
        style="font-size: 12px; line-height: 1;">
        <i class="fa fa-trash"></i>
    </button>

    <form id="delete-form-{{ $proposal->id }}"
        action="{{ route('projects.destroy', $proposal->id) }}"
        method="POST" class="d-none">
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

    <style>
    .table td .btn-xs {
        padding: 5px !important;
        font-size: 12px !important;
        line-height: 1 !important;
    }
    .table td {
        padding: 4px 6px !important;
        vertical-align: middle !important;
    }
</style>


    {{-- Inline update script --}}
    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // --- helpers ---
        function updateDropdownColor(el) {
            el.classList.remove('yes', 'no');
            const val = (el.value || '').toLowerCase().trim();
            el.classList.add(val === 'yes' ? 'yes' : 'no');
        }

        function swalConfirm(column, valueForText) {
            return Swal.fire({
                title: 'Confirm update',
                text: `Update "${column}" to "${valueForText}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'Cancel'
            });
        }

        async function sendInlineUpdate(id, column, value) {
            const url = "{{ route('projects.inline', ['project' => '__ID__']) }}".replace('__ID__', id);

            const res = await fetch(url, {
                method: 'POST', // POST + _method=PATCH
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    column,
                    value,
                    _method: 'PATCH'
                })
            });

            if (!res.ok) throw new Error(await res.text());
            return await res.json();
        }

        // Keep previous values to revert on cancel/failure
        document.addEventListener('focusin', (e) => {
            const t = e.target;
            if (t.matches('select, input.inline-edit, .inline-cell[contenteditable="true"]')) {
                // store previous
                t.dataset.prev = t.matches('.inline-cell') ? (t.innerText || t.textContent || '').trim() :
                    (t.value || '').trim();
            }
        });

        // Handle dropdown and input changes (with confirmation)
        document.addEventListener('change', async (e) => {
            const tgt = e.target;
            const tr = tgt.closest('tr[data-id]');
            if (!tr) return;

            const id = tr.getAttribute('data-id');
            const col = tgt.getAttribute('data-col');
            if (!col) return;

            // Figure out new value + text for confirmation
            let newVal, confirmTextVal;

            if (tgt.matches('select.dropdown-yesno')) {
                newVal = (tgt.value || '').toLowerCase().trim() === 'yes';
                confirmTextVal = newVal ? 'Yes' : 'No';
            } else if (tgt.matches('select.inline-select')) {
                newVal = tgt.value;
                confirmTextVal = newVal;
            } else if (tgt.matches('input.inline-edit[data-col]')) {
                newVal = (tgt.value || '').trim();
                confirmTextVal = newVal || '—';
            } else {
                return; // not our target
            }

            const prev = tgt.dataset.prev ?? (tgt.matches('select') ? tgt.value : '');

            const {
                isConfirmed
            } = await swalConfirm(col, confirmTextVal);
            if (!isConfirmed) {
                // revert UI
                if (tgt.matches('select')) {
                    tgt.value = prev || tgt.value;
                    if (tgt.matches('.dropdown-yesno')) updateDropdownColor(tgt);
                } else {
                    tgt.value = prev || '';
                }
                return;
            }

            try {
                await sendInlineUpdate(id, col, newVal);
                // success toast (optional)
                Swal.fire({
                    toast: true,
                    position: 'top',
                    timer: 1200,
                    showConfirmButton: false,
                    icon: 'success',
                    title: 'Updated'
                });
                // update color for yes/no
                if (tgt.matches('.dropdown-yesno')) updateDropdownColor(tgt);
                // refresh prev snapshot to new
                tgt.dataset.prev = tgt.matches('select') ? tgt.value : (tgt.value || '').trim();
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Update failed',
                    text: 'Please try again.'
                });
                // revert on failure
                if (tgt.matches('select')) {
                    tgt.value = prev || tgt.value;
                    if (tgt.matches('.dropdown-yesno')) updateDropdownColor(tgt);
                } else {
                    tgt.value = prev || '';
                }
            }
        });

        // Handle contenteditable cells (confirm on blur)
        document.addEventListener('blur', async (e) => {
            const tgt = e.target;
            if (!tgt.matches('.inline-cell[data-col][contenteditable="true"]')) return;

            const tr = tgt.closest('tr[data-id]');
            if (!tr) return;

            const id = tr.getAttribute('data-id');
            const col = tgt.getAttribute('data-col');

            const prev = tgt.dataset.prev ?? '';
            let val = (tgt.innerText || tgt.textContent || '').trim();
            if (val === '—') val = '';

            // No change — skip
            if (val === prev) return;

            const {
                isConfirmed
            } = await swalConfirm(col, val || '—');
            if (!isConfirmed) {
                // revert
                tgt.innerText = prev;
                return;
            }

            try {
                await sendInlineUpdate(id, col, val);
                Swal.fire({
                    toast: true,
                    position: 'top',
                    timer: 1200,
                    showConfirmButton: false,
                    icon: 'success',
                    title: 'Updated'
                });
                tgt.dataset.prev = val;
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Update failed',
                    text: 'Please try again.'
                });
                // revert on failure
                tgt.innerText = prev;
            }
        }, true);
    </script>

    <script>
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.btn-delete');
            if (!btn) return;

            const id = btn.dataset.id;
            const form = document.getElementById(`delete-form-${id}`);

            const {
                isConfirmed
            } = await Swal.fire({
                title: 'Delete proposal?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            });

            if (!isConfirmed) return;

            // Submit the hidden form (standard DELETE with CSRF)
            form.submit();
        });
    </script>


@endsection
