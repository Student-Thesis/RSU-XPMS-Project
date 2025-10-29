@extends('layouts.app')

@section('content')
<div id="content">
    @include('layouts.partials.topnav')

    <div class="midde_cont">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success my-3">{{ session('success') }}</div>
            @endif

            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title d-flex justify-content-between align-items-center">
                        <h3>EXTENSION PERFORMANCE INDICATORS AND TARGETS</h3>
                        <a href="{{ route('faculties.create') }}" class="btn btn-primary">Add Record</a>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('faculties.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label"><strong>Search:</strong></label>
                    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search campus or number...">
                </div>
                <div class="col-md-4">
                    <label class="form-label"><strong>Filter by College/Campus:</strong></label>
                    @php
                        $colleges = ['All','CAS','CBA','CET','CAFES','CCMADI','CED','GEPS','CALATRAVA CAMPUS',
                                     'STA. MARIA CAMPUS','SANTA FE CAMPUS','SAN ANDRES CAMPUS',
                                     'SAN AGUSTIN CAMPUS','ROMBLON CAMPUS','CAJIDIOCAN CAMPUS','SAN FERNANDO CAMPUS'];
                    @endphp
                    <select name="college" class="form-control">
                        @foreach($colleges as $c)
                            <option value="{{ $c }}" @selected(($college ?? 'All') === $c)>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-dark me-2" type="submit">Apply</button>
                    <a href="{{ route('faculties.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>

            <div class="table-responsive" style="margin-top: 20px;">
                <table class="table table-bordered table-striped text-center align-middle" id="proposalTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Campus/College</th>
                            <th>Faculties</th>

                            <th>Involved in Extension (Total)</th>
                            <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>

                            <th>IEC Developed (Total)</th>
                            <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>

                            <th>IEC Reproduced (Total)</th>
                            <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>

                            <th>IEC Distributed (Total)</th>
                            <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>

                            <th>Proposals Approved (Total)</th>
                            <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>

                            <th>Proposals Implemented (Total)</th>
                            <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>

                            <th>Proposals Documented (Total)</th>
                            <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>

                            <th>Community Served (Total)</th>
                            <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>

                            <th>Beneficiaries Assistance (Total)</th>
                            <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>

                            <th>MOA/MOU (Total)</th>
                            <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>

                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $i => $row)
                            <tr>
                                <td>{{ $rows->firstItem() + $i }}</td>
                                <td>{{ $row->campus_college }}</td>
                                <td>{{ $row->num_faculties }}</td>

                                <td>{{ $row->involved_extension_total }}</td>
                                <td>{{ $row->involved_extension_q1 }}</td>
                                <td>{{ $row->involved_extension_q2 }}</td>
                                <td>{{ $row->involved_extension_q3 }}</td>
                                <td>{{ $row->involved_extension_q4 }}</td>

                                <td>{{ $row->iec_developed_total }}</td>
                                <td>{{ $row->iec_developed_q1 }}</td>
                                <td>{{ $row->iec_developed_q2 }}</td>
                                <td>{{ $row->iec_developed_q3 }}</td>
                                <td>{{ $row->iec_developed_q4 }}</td>

                                <td>{{ $row->iec_reproduced_total }}</td>
                                <td>{{ $row->iec_reproduced_q1 }}</td>
                                <td>{{ $row->iec_reproduced_q2 }}</td>
                                <td>{{ $row->iec_reproduced_q3 }}</td>
                                <td>{{ $row->iec_reproduced_q4 }}</td>

                                <td>{{ $row->iec_distributed_total }}</td>
                                <td>{{ $row->iec_distributed_q1 }}</td>
                                <td>{{ $row->iec_distributed_q2 }}</td>
                                <td>{{ $row->iec_distributed_q3 }}</td>
                                <td>{{ $row->iec_distributed_q4 }}</td>

                                <td>{{ $row->proposals_approved_total }}</td>
                                <td>{{ $row->proposals_approved_q1 }}</td>
                                <td>{{ $row->proposals_approved_q2 }}</td>
                                <td>{{ $row->proposals_approved_q3 }}</td>
                                <td>{{ $row->proposals_approved_q4 }}</td>

                                <td>{{ $row->proposals_implemented_total }}</td>
                                <td>{{ $row->proposals_implemented_q1 }}</td>
                                <td>{{ $row->proposals_implemented_q2 }}</td>
                                <td>{{ $row->proposals_implemented_q3 }}</td>
                                <td>{{ $row->proposals_implemented_q4 }}</td>

                                <td>{{ $row->proposals_documented_total }}</td>
                                <td>{{ $row->proposals_documented_q1 }}</td>
                                <td>{{ $row->proposals_documented_q2 }}</td>
                                <td>{{ $row->proposals_documented_q3 }}</td>
                                <td>{{ $row->proposals_documented_q4 }}</td>

                                <td>{{ $row->community_served_total }}</td>
                                <td>{{ $row->community_served_q1 }}</td>
                                <td>{{ $row->community_served_q2 }}</td>
                                <td>{{ $row->community_served_q3 }}</td>
                                <td>{{ $row->community_served_q4 }}</td>

                                <td>{{ $row->beneficiaries_assistance_total }}</td>
                                <td>{{ $row->beneficiaries_assistance_q1 }}</td>
                                <td>{{ $row->beneficiaries_assistance_q2 }}</td>
                                <td>{{ $row->beneficiaries_assistance_q3 }}</td>
                                <td>{{ $row->beneficiaries_assistance_q4 }}</td>

                                <td>{{ $row->moa_mou_total }}</td>
                                <td>{{ $row->moa_mou_q1 }}</td>
                                <td>{{ $row->moa_mou_q2 }}</td>
                                <td>{{ $row->moa_mou_q3 }}</td>
                                <td>{{ $row->moa_mou_q4 }}</td>

                                <td class="text-nowrap">
                                    <a href="{{ route('faculties.edit', $row) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('faculties.destroy', $row) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="999">No records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $rows->links() }}
        </div>
    </div>
</div>
@endsection
