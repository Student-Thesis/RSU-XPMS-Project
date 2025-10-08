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
                <div class="row">
                    <div class="col-md-4">
                        <label><strong>Search:</strong></label>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search anything..."
                            onkeyup="filterTable()">
                    </div>
                    <div class="col-md-4">
                        <label><strong>Filter by College/Campus:</strong></label>
                        <select id="collegeFilter" class="form-control" onchange="filterTable()">
                            <option value="All">All</option>
                            <option value="CAS">CAS</option>
                            <option value="CBA">CBA</option>
                            <option value="CET">CET</option>
                            <option value="CAFES">CAFES</option>
                            <option value="CCMADI">CCMADI</option>
                            <option value="CED">CED</option>
                            <option value="GEPS">GEPS</option>
                            <option value="CALATRAVA CAMPUS">CALATRAVA CAMPUS</option>
                            <option value="STA. MARIA CAMPUS">STA. MARIA CAMPUS</option>
                            <option value="SANTA FE CAMPUS">SANTA FE CAMPUS</option>
                            <option value="SAN ANDRES CAMPUS">SAN ANDRES CAMPUS</option>
                            <option value="SAN AGUSTIN CAMPUS">SAN AGUSTIN CAMPUS</option>
                            <option value="ROMBLON CAMPUS">ROMBLON CAMPUS</option>
                            <option value="CAJIDIOCAN CAMPUS">CAJIDIOCAN CAMPUS</option>
                            <option value="SAN FERNANDO CAMPUS">SAN FERNANDO CAMPUS</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label><strong>Filter by Status:</strong></label>
                        <select id="statusFilter" class="form-control" onchange="filterTable()">
                            <option value="All">All</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>

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
                                <th>Photos</th>
                                <th>Terminal Report</th>
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proposals as $proposal)
                                @php
                                    $leader = $proposal->leader ?? '—';
                                    $collegeCampus = $proposal->location ?? '—'; // mapping 'location' => College/Campus
                                    $team = $proposal->team_members ?: '—';
                                    $agenda = $proposal->target_agenda ?: '—';
                                    $approvedBudget = number_format($proposal->approved_budget, 2);
                                    // Temporary defaults for fields not in DB yet:
                                    $statusText = 'Ongoing';
                                    $fundUtilRate = '—';
                                    $sourceOfFunds = $proposal->partner ?: '—';
                                    $code =
                                        optional($proposal->created_at)->format('Y') .
                                        '-' .
                                        str_pad($loop->iteration, 3, '0', STR_PAD_LEFT);
                                @endphp

                                <tr data-id="{{ $proposal->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $proposal->title }}</td>

                                    {{-- Classification (optional inline edit – you can wire it the same way if you want) --}}
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
                                    <td class="agenda-education">{{ $agenda }}</td>

                                    {{-- YES/NO columns – repeat pattern and just change data-col --}}
                                    {{-- In-House --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->in_house ? 'yes' : 'no' }}"
                                            data-col="in_house" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->in_house ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->in_house ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Revised Proposal --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->revised_proposal ? 'yes' : 'no' }}"
                                            data-col="revised_proposal" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->revised_proposal ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->revised_proposal ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- NTP --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->ntp ? 'yes' : 'no' }}" data-col="ntp"
                                            onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->ntp ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->ntp ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Endorsement --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->endorsement ? 'yes' : 'no' }}"
                                            data-col="endorsement" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->endorsement ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->endorsement ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Proposal Presentation --}}
                                    <td>
                                        <select
                                            class="dropdown-yesno {{ $proposal->proposal_presentation ? 'yes' : 'no' }}"
                                            data-col="proposal_presentation" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->proposal_presentation ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->proposal_presentation ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Proposal Documents --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->proposal_documents ? 'yes' : 'no' }}"
                                            data-col="proposal_documents" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->proposal_documents ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->proposal_documents ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Program Proposal --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->program_proposal ? 'yes' : 'no' }}"
                                            data-col="program_proposal" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->program_proposal ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->program_proposal ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Project Proposal --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->project_proposal ? 'yes' : 'no' }}"
                                            data-col="project_proposal" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->project_proposal ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->project_proposal ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- MOA/MOU --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->moa_mou ? 'yes' : 'no' }}"
                                            data-col="moa_mou" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->moa_mou ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->moa_mou ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Activity Design --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->activity_design ? 'yes' : 'no' }}"
                                            data-col="activity_design" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->activity_design ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->activity_design ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Certificate of Appearance --}}
                                    <td>
                                        <select
                                            class="dropdown-yesno {{ $proposal->certificate_of_appearance ? 'yes' : 'no' }}"
                                            data-col="certificate_of_appearance" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->certificate_of_appearance ? 'selected' : '' }}>No
                                            </option>
                                            <option {{ $proposal->certificate_of_appearance ? 'selected' : '' }}>Yes
                                            </option>
                                        </select>
                                    </td>

                                    {{-- Attendance Sheet --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->attendance_sheet ? 'yes' : 'no' }}"
                                            data-col="attendance_sheet" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->attendance_sheet ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->attendance_sheet ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Photos --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->photos ? 'yes' : 'no' }}"
                                            data-col="photos" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->photos ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->photos ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Terminal Report --}}
                                    <td>
                                        <select class="dropdown-yesno {{ $proposal->terminal_report ? 'yes' : 'no' }}"
                                            data-col="terminal_report" onchange="updateDropdownColor(this)">
                                            <option {{ !$proposal->terminal_report ? 'selected' : '' }}>No</option>
                                            <option {{ $proposal->terminal_report ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </td>

                                    {{-- Approved Budget (computed) – shown only --}}
                                    <td>{{ $approvedBudget }}</td>

                                    {{-- The following are editable text/number cells --}}
                                    <td contenteditable="true" class="inline-cell" data-col="source_of_funds">
                                        {{ $proposal->source_of_funds ?? '—' }}</td>
                                    <td contenteditable="true" class="inline-cell" data-col="expenditure">
                                        {{ $proposal->expenditure ?? '—' }}</td>
                                    <td contenteditable="true" class="inline-cell" data-col="fund_utilization_rate">
                                        {{ $proposal->fund_utilization_rate ?? '—' }}</td>
                                    <td>{{ $proposal->partner ?: '—' }}</td>

                                    {{-- Status (dropdown) --}}
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

    {{-- Inline update script --}}
    {{-- Inline update script (with SweetAlert2 confirmation + revert) --}}
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

@endsection
