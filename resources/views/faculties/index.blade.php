@extends('layouts.app')

@section('content')
    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <h3 class="mb-0">
                        EXTENSION PERFORMANCE INDICATORS AND TARGETS
                    </h3>
                </div>
                <div class="col-sm-4 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('faculties.create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus me-1"></i> Add Record
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3 mb-0" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    {{-- FILTERS --}}
                    <form method="GET" action="{{ route('faculties.index') }}" class="row align-items-end g-3 mb-3"
                        id="facultyFilterForm">

                        {{-- Search --}}
                        <div class="col-md-6 col-12">
                            <label class="form-label mb-1"><strong>Search:</strong></label>
                            <input type="text" name="q" id="filterSearch" value="{{ $q }}"
                                class="form-control form-control-sm" placeholder="Search campus or number…">
                        </div>

                        {{-- College Filter --}}
                        <div class="col-md-6 col-12">
                            <label class="form-label mb-1"><strong>Filter by College/Campus:</strong></label>
                            @php
                                $colleges = [
                                    'All',
                                    'CAS',
                                    'CBA',
                                    'CET',
                                    'CAFES',
                                    'CCMADI',
                                    'CED',
                                    'GEPS',
                                    'CALATRAVA CAMPUS',
                                    'STA. MARIA CAMPUS',
                                    'SANTA FE CAMPUS',
                                    'SAN ANDRES CAMPUS',
                                    'SAN AGUSTIN CAMPUS',
                                    'ROMBLON CAMPUS',
                                    'CAJIDIOCAN CAMPUS',
                                    'SAN FERNANDO CAMPUS',
                                ];
                            @endphp

                            <select name="college" id="filterCollege" class="form-select form-select-sm">
                                @foreach ($colleges as $c)
                                    <option value="{{ $c }}" @selected(($college ?? 'All') === $c)>
                                        {{ $c }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    {{-- TABLE --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-striped table-sm text-center align-middle"
                            id="facultyTable">
                            <thead class="table-dark align-middle">
                                <tr>
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Campus / College</th>
                                    <th rowspan="2">Faculties</th>

                                    <th colspan="5" data-group="involved_extension">Involved in Extension</th>
                                    <th colspan="5" data-group="iec_developed">IEC Developed</th>
                                    <th colspan="5" data-group="iec_reproduced">IEC Reproduced</th>
                                    <th colspan="5" data-group="iec_distributed">IEC Distributed</th>
                                    <th colspan="5" data-group="proposals_approved">Proposals Approved</th>
                                    <th colspan="5" data-group="proposals_implemented">Proposals Implemented</th>
                                    <th colspan="5" data-group="proposals_documented">Proposals Documented</th>
                                    <th colspan="5" data-group="community_served">Community Served</th>
                                    <th colspan="5" data-group="beneficiaries_assistance">Beneficiaries Assistance</th>
                                    <th colspan="5" data-group="moa_mou">MOA / MOU</th>

                                    <th rowspan="2">Actions</th>
                                </tr>

                                <tr>
                                    {{-- Involved --}}
                                    <th data-group="involved_extension">Total</th>
                                    <th data-group="involved_extension">Q1</th>
                                    <th data-group="involved_extension">Q2</th>
                                    <th data-group="involved_extension">Q3</th>
                                    <th data-group="involved_extension">Q4</th>

                                    {{-- IEC Developed --}}
                                    <th data-group="iec_developed">Total</th>
                                    <th data-group="iec_developed">Q1</th>
                                    <th data-group="iec_developed">Q2</th>
                                    <th data-group="iec_developed">Q3</th>
                                    <th data-group="iec_developed">Q4</th>

                                    {{-- IEC Reproduced --}}
                                    <th data-group="iec_reproduced">Total</th>
                                    <th data-group="iec_reproduced">Q1</th>
                                    <th data-group="iec_reproduced">Q2</th>
                                    <th data-group="iec_reproduced">Q3</th>
                                    <th data-group="iec_reproduced">Q4</th>

                                    {{-- IEC Distributed --}}
                                    <th data-group="iec_distributed">Total</th>
                                    <th data-group="iec_distributed">Q1</th>
                                    <th data-group="iec_distributed">Q2</th>
                                    <th data-group="iec_distributed">Q3</th>
                                    <th data-group="iec_distributed">Q4</th>

                                    {{-- Approved --}}
                                    <th data-group="proposals_approved">Total</th>
                                    <th data-group="proposals_approved">Q1</th>
                                    <th data-group="proposals_approved">Q2</th>
                                    <th data-group="proposals_approved">Q3</th>
                                    <th data-group="proposals_approved">Q4</th>

                                    {{-- Implemented --}}
                                    <th data-group="proposals_implemented">Total</th>
                                    <th data-group="proposals_implemented">Q1</th>
                                    <th data-group="proposals_implemented">Q2</th>
                                    <th data-group="proposals_implemented">Q3</th>
                                    <th data-group="proposals_implemented">Q4</th>

                                    {{-- Documented --}}
                                    <th data-group="proposals_documented">Total</th>
                                    <th data-group="proposals_documented">Q1</th>
                                    <th data-group="proposals_documented">Q2</th>
                                    <th data-group="proposals_documented">Q3</th>
                                    <th data-group="proposals_documented">Q4</th>

                                    {{-- Community --}}
                                    <th data-group="community_served">Total</th>
                                    <th data-group="community_served">Q1</th>
                                    <th data-group="community_served">Q2</th>
                                    <th data-group="community_served">Q3</th>
                                    <th data-group="community_served">Q4</th>

                                    {{-- Beneficiaries --}}
                                    <th data-group="beneficiaries_assistance">Total</th>
                                    <th data-group="beneficiaries_assistance">Q1</th>
                                    <th data-group="beneficiaries_assistance">Q2</th>
                                    <th data-group="beneficiaries_assistance">Q3</th>
                                    <th data-group="beneficiaries_assistance">Q4</th>

                                    {{-- MOA/MOU --}}
                                    <th data-group="moa_mou">Total</th>
                                    <th data-group="moa_mou">Q1</th>
                                    <th data-group="moa_mou">Q2</th>
                                    <th data-group="moa_mou">Q3</th>
                                    <th data-group="moa_mou">Q4</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($rows as $i => $row)
                                    <tr>
                                        <td>{{ $rows->firstItem() + $i }}</td>
                                        <td class="text-start">{{ $row->campus_college }}</td>
                                        <td>{{ $row->num_faculties }}</td>

                                        {{-- Involved --}}
                                        <td data-group="involved_extension">{{ $row->involved_extension_total }}</td>
                                        <td data-group="involved_extension">{{ $row->involved_extension_q1 }}</td>
                                        <td data-group="involved_extension">{{ $row->involved_extension_q2 }}</td>
                                        <td data-group="involved_extension">{{ $row->involved_extension_q3 }}</td>
                                        <td data-group="involved_extension">{{ $row->involved_extension_q4 }}</td>

                                        {{-- IEC Developed --}}
                                        <td data-group="iec_developed">{{ $row->iec_developed_total }}</td>
                                        <td data-group="iec_developed">{{ $row->iec_developed_q1 }}</td>
                                        <td data-group="iec_developed">{{ $row->iec_developed_q2 }}</td>
                                        <td data-group="iec_developed">{{ $row->iec_developed_q3 }}</td>
                                        <td data-group="iec_developed">{{ $row->iec_developed_q4 }}</td>

                                        {{-- IEC Reproduced --}}
                                        <td data-group="iec_reproduced">{{ $row->iec_reproduced_total }}</td>
                                        <td data-group="iec_reproduced">{{ $row->iec_reproduced_q1 }}</td>
                                        <td data-group="iec_reproduced">{{ $row->iec_reproduced_q2 }}</td>
                                        <td data-group="iec_reproduced">{{ $row->iec_reproduced_q3 }}</td>
                                        <td data-group="iec_reproduced">{{ $row->iec_reproduced_q4 }}</td>

                                        {{-- IEC Distributed --}}
                                        <td data-group="iec_distributed">{{ $row->iec_distributed_total }}</td>
                                        <td data-group="iec_distributed">{{ $row->iec_distributed_q1 }}</td>
                                        <td data-group="iec_distributed">{{ $row->iec_distributed_q2 }}</td>
                                        <td data-group="iec_distributed">{{ $row->iec_distributed_q3 }}</td>
                                        <td data-group="iec_distributed">{{ $row->iec_distributed_q4 }}</td>

                                        {{-- Approved --}}
                                        <td data-group="proposals_approved">{{ $row->proposals_approved_total }}</td>
                                        <td data-group="proposals_approved">{{ $row->proposals_approved_q1 }}</td>
                                        <td data-group="proposals_approved">{{ $row->proposals_approved_q2 }}</td>
                                        <td data-group="proposals_approved">{{ $row->proposals_approved_q3 }}</td>
                                        <td data-group="proposals_approved">{{ $row->proposals_approved_q4 }}</td>

                                        {{-- Implemented --}}
                                        <td data-group="proposals_implemented">{{ $row->proposals_implemented_total }}
                                        </td>
                                        <td data-group="proposals_implemented">{{ $row->proposals_implemented_q1 }}</td>
                                        <td data-group="proposals_implemented">{{ $row->proposals_implemented_q2 }}</td>
                                        <td data-group="proposals_implemented">{{ $row->proposals_implemented_q3 }}</td>
                                        <td data-group="proposals_implemented">{{ $row->proposals_implemented_q4 }}</td>

                                        {{-- Documented --}}
                                        <td data-group="proposals_documented">{{ $row->proposals_documented_total }}</td>
                                        <td data-group="proposals_documented">{{ $row->proposals_documented_q1 }}</td>
                                        <td data-group="proposals_documented">{{ $row->proposals_documented_q2 }}</td>
                                        <td data-group="proposals_documented">{{ $row->proposals_documented_q3 }}</td>
                                        <td data-group="proposals_documented">{{ $row->proposals_documented_q4 }}</td>

                                        {{-- Community --}}
                                        <td data-group="community_served">{{ $row->community_served_total }}</td>
                                        <td data-group="community_served">{{ $row->community_served_q1 }}</td>
                                        <td data-group="community_served">{{ $row->community_served_q2 }}</td>
                                        <td data-group="community_served">{{ $row->community_served_q3 }}</td>
                                        <td data-group="community_served">{{ $row->community_served_q4 }}</td>

                                        {{-- Beneficiaries --}}
                                        <td data-group="beneficiaries_assistance">
                                            {{ $row->beneficiaries_assistance_total }}</td>
                                        <td data-group="beneficiaries_assistance">{{ $row->beneficiaries_assistance_q1 }}
                                        </td>
                                        <td data-group="beneficiaries_assistance">{{ $row->beneficiaries_assistance_q2 }}
                                        </td>
                                        <td data-group="beneficiaries_assistance">{{ $row->beneficiaries_assistance_q3 }}
                                        </td>
                                        <td data-group="beneficiaries_assistance">{{ $row->beneficiaries_assistance_q4 }}
                                        </td>

                                        {{-- MOA/MOU --}}
                                        <td data-group="moa_mou">{{ $row->moa_mou_total }}</td>
                                        <td data-group="moa_mou">{{ $row->moa_mou_q1 }}</td>
                                        <td data-group="moa_mou">{{ $row->moa_mou_q2 }}</td>
                                        <td data-group="moa_mou">{{ $row->moa_mou_q3 }}</td>
                                        <td data-group="moa_mou">{{ $row->moa_mou_q4 }}</td>

                                        <td class="text-nowrap">
                                            <a href="{{ route('faculties.edit', $row) }}"
                                                class="btn btn-warning btn-xs text-white me-1" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('faculties.destroy', $row) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-xs" title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="999" class="text-center text-muted py-4">
                                            No records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <style>
                        .col-highlight {
                            background: #fff3cd !important;
                            transition: background .25s ease;
                        }

                        /* Table tweaks */
                        #facultyTable {
                            font-size: 0.78rem;
                            table-layout: auto;
                            min-width: 100%;
                            white-space: nowrap;
                        }

                        #facultyTable th,
                        #facultyTable td {
                            padding: 4px 6px !important;
                            vertical-align: middle !important;
                        }

                        #facultyTable thead th {
                            text-align: center;
                        }

                        #facultyTable thead th {
                            position: sticky;
                            top: 0;
                            z-index: 2;
                        }
                    </style>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const params = new URLSearchParams(window.location.search);
                            const focus = params.get('focus');
                            if (!focus) return;

                            const tableWrap = document.querySelector('.table-responsive');
                            const table = document.getElementById('facultyTable');
                            if (!table || !tableWrap) return;

                            const cells = table.querySelectorAll(`[data-group="${focus}"]`);
                            if (!cells.length) return;

                            cells.forEach(el => el.classList.add('col-highlight'));

                            // horizontal scroll to first cell
                            const first = cells[0];
                            const wrapRect = tableWrap.getBoundingClientRect();
                            const firstRect = first.getBoundingClientRect();
                            const offset = (firstRect.left - wrapRect.left);

                            tableWrap.scrollLeft += (offset - 40);

                            // optional remove highlight after 4s
                            setTimeout(() => {
                                cells.forEach(el => el.classList.remove('col-highlight'));
                            }, 4000);
                        });
                    </script>


                    {{-- PAGINATION --}}
                    <div class="mt-3">
                        {{ $rows->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- PAGE STYLES --}}
    <style>
        /* Extra small button style (reuse across app) */
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

        .btn-xs i {
            line-height: 1;
            font-size: 0.85em;
        }

        /* Table tweaks */
        #facultyTable {
            font-size: 0.78rem;
            table-layout: auto;
            min-width: 100%;
            white-space: nowrap;
        }

        #facultyTable th,
        #facultyTable td {
            padding: 4px 6px !important;
            vertical-align: middle !important;
        }

        #facultyTable thead th {
            text-align: center;
        }

        /* Make header row stick on scroll (optional) */
        #facultyTable thead th {
            position: sticky;
            top: 0;
            z-index: 2;
        }
    </style>

    {{-- PAGE SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('facultyFilterForm');
            const searchInput = document.getElementById('filterSearch');
            const collegeSelect = document.getElementById('filterCollege');

            let typingTimer = null;
            const doneTypingDelay = 500; // ms

            if (searchInput && form) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(function() {
                        form.submit();
                    }, doneTypingDelay);
                });

                // Allow pressing Enter to submit immediately
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.submit();
                    }
                });
            }

            if (collegeSelect && form) {
                collegeSelect.addEventListener('change', function() {
                    form.submit();
                });
            }
        });
    </script>
@endsection
