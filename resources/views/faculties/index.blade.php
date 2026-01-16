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
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
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
                    <form method="GET"
                          action="{{ route('faculties.index') }}"
                          class="row align-items-end g-3 mb-3"
                          id="facultyFilterForm">

                        {{-- Search --}}
                        <div class="col-md-6 col-12">
                            <label class="form-label mb-1"><strong>Search:</strong></label>
                            <input type="text"
                                   name="q"
                                   id="filterSearch"
                                   value="{{ $q }}"
                                   class="form-control form-control-sm"
                                   placeholder="Search campus or number…">
                        </div>

                        {{-- College Filter --}}
                        <div class="col-md-6 col-12">
                            <label class="form-label mb-1"><strong>Filter by College/Campus:</strong></label>
                            @php
                                $colleges = [
                                    'All',
                                    'CAS', 'CBA', 'CET', 'CAFES', 'CCMADI', 'CED', 'GEPS',
                                    'CALATRAVA CAMPUS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS',
                                    'SAN ANDRES CAMPUS', 'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS',
                                    'CAJIDIOCAN CAMPUS', 'SAN FERNANDO CAMPUS',
                                ];
                            @endphp

                            <select name="college"
                                    id="filterCollege"
                                    class="form-select form-select-sm">
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

                                    {{-- Involved in Extension --}}
                                    <th colspan="5">Involved in Extension</th>

                                    {{-- IEC Developed --}}
                                    <th colspan="5">IEC Developed</th>

                                    {{-- IEC Reproduced --}}
                                    <th colspan="5">IEC Reproduced</th>

                                    {{-- IEC Distributed --}}
                                    <th colspan="5">IEC Distributed</th>

                                    {{-- Proposals Approved --}}
                                    <th colspan="5">Proposals Approved</th>

                                    {{-- Proposals Implemented --}}
                                    <th colspan="5">Proposals Implemented</th>

                                    {{-- Proposals Documented --}}
                                    <th colspan="5">Proposals Documented</th>

                                    {{-- Community Served --}}
                                    <th colspan="5">Community Served</th>

                                    {{-- Beneficiaries Assistance --}}
                                    <th colspan="5">Beneficiaries Assistance</th>

                                    {{-- MOA / MOU --}}
                                    <th colspan="5">MOA / MOU</th>

                                    <th rowspan="2">Actions</th>
                                </tr>
                                <tr>
                                    {{-- For each group: Total, Q1, Q2, Q3, Q4 (10 groups) --}}
                                    @for ($i = 0; $i < 10; $i++)
                                        <th>Total</th>
                                        <th>Q1</th>
                                        <th>Q2</th>
                                        <th>Q3</th>
                                        <th>Q4</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rows as $i => $row)
                                    <tr>
                                        <td>{{ $rows->firstItem() + $i }}</td>
                                        <td class="text-start">{{ $row->campus_college }}</td>
                                        <td>{{ $row->num_faculties }}</td>

                                        {{-- Involved in Extension --}}
                                        <td>{{ $row->involved_extension_total }}</td>
                                        <td>{{ $row->involved_extension_q1 }}</td>
                                        <td>{{ $row->involved_extension_q2 }}</td>
                                        <td>{{ $row->involved_extension_q3 }}</td>
                                        <td>{{ $row->involved_extension_q4 }}</td>

                                        {{-- IEC Developed --}}
                                        <td>{{ $row->iec_developed_total }}</td>
                                        <td>{{ $row->iec_developed_q1 }}</td>
                                        <td>{{ $row->iec_developed_q2 }}</td>
                                        <td>{{ $row->iec_developed_q3 }}</td>
                                        <td>{{ $row->iec_developed_q4 }}</td>

                                        {{-- IEC Reproduced --}}
                                        <td>{{ $row->iec_reproduced_total }}</td>
                                        <td>{{ $row->iec_reproduced_q1 }}</td>
                                        <td>{{ $row->iec_reproduced_q2 }}</td>
                                        <td>{{ $row->iec_reproduced_q3 }}</td>
                                        <td>{{ $row->iec_reproduced_q4 }}</td>

                                        {{-- IEC Distributed --}}
                                        <td>{{ $row->iec_distributed_total }}</td>
                                        <td>{{ $row->iec_distributed_q1 }}</td>
                                        <td>{{ $row->iec_distributed_q2 }}</td>
                                        <td>{{ $row->iec_distributed_q3 }}</td>
                                        <td>{{ $row->iec_distributed_q4 }}</td>

                                        {{-- Proposals Approved --}}
                                        <td>{{ $row->proposals_approved_total }}</td>
                                        <td>{{ $row->proposals_approved_q1 }}</td>
                                        <td>{{ $row->proposals_approved_q2 }}</td>
                                        <td>{{ $row->proposals_approved_q3 }}</td>
                                        <td>{{ $row->proposals_approved_q4 }}</td>

                                        {{-- Proposals Implemented --}}
                                        <td>{{ $row->proposals_implemented_total }}</td>
                                        <td>{{ $row->proposals_implemented_q1 }}</td>
                                        <td>{{ $row->proposals_implemented_q2 }}</td>
                                        <td>{{ $row->proposals_implemented_q3 }}</td>
                                        <td>{{ $row->proposals_implemented_q4 }}</td>

                                        {{-- Proposals Documented --}}
                                        <td>{{ $row->proposals_documented_total }}</td>
                                        <td>{{ $row->proposals_documented_q1 }}</td>
                                        <td>{{ $row->proposals_documented_q2 }}</td>
                                        <td>{{ $row->proposals_documented_q3 }}</td>
                                        <td>{{ $row->proposals_documented_q4 }}</td>

                                        {{-- Community Served --}}
                                        <td>{{ $row->community_served_total }}</td>
                                        <td>{{ $row->community_served_q1 }}</td>
                                        <td>{{ $row->community_served_q2 }}</td>
                                        <td>{{ $row->community_served_q3 }}</td>
                                        <td>{{ $row->community_served_q4 }}</td>

                                        {{-- Beneficiaries Assistance --}}
                                        <td>{{ $row->beneficiaries_assistance_total }}</td>
                                        <td>{{ $row->beneficiaries_assistance_q1 }}</td>
                                        <td>{{ $row->beneficiaries_assistance_q2 }}</td>
                                        <td>{{ $row->beneficiaries_assistance_q3 }}</td>
                                        <td>{{ $row->beneficiaries_assistance_q4 }}</td>

                                        {{-- MOA / MOU --}}
                                        <td>{{ $row->moa_mou_total }}</td>
                                        <td>{{ $row->moa_mou_q1 }}</td>
                                        <td>{{ $row->moa_mou_q2 }}</td>
                                        <td>{{ $row->moa_mou_q3 }}</td>
                                        <td>{{ $row->moa_mou_q4 }}</td>

                                       <td class="text-nowrap">
    <a href="{{ route('faculties.edit', $row) }}"
       class="btn btn-warning btn-xs text-white me-1"
       title="Edit">
        <i class="bi bi-pencil-square"></i>
    </a>

    <form action="{{ route('faculties.destroy', $row) }}"
          method="POST"
          class="d-inline"
          onsubmit="return confirm('Delete this record?')">
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
                                        <td colspan="999"
                                            class="text-center text-muted py-4">
                                            No records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

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
        document.addEventListener('DOMContentLoaded', function () {
            const form          = document.getElementById('facultyFilterForm');
            const searchInput   = document.getElementById('filterSearch');
            const collegeSelect = document.getElementById('filterCollege');

            let typingTimer = null;
            const doneTypingDelay = 500; // ms

            if (searchInput && form) {
                searchInput.addEventListener('input', function () {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(function () {
                        form.submit();
                    }, doneTypingDelay);
                });

                // Allow pressing Enter to submit immediately
                searchInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.submit();
                    }
                });
            }

            if (collegeSelect && form) {
                collegeSelect.addEventListener('change', function () {
                    form.submit();
                });
            }
        });
    </script>
@endsection
