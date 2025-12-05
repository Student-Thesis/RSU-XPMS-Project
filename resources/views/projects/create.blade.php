@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')

        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title d-flex align-items-center justify-content-between gap-2 flex-wrap">
                            <h3 class="m-0">Create New Proposal</h3>

                            {{-- Go to full-page create form --}}
                            <a href="{{ route('projects') }}" class="btn btn-success btn-sm">
                               < Back
                            </a>
                        </div>
                    </div>
                </div>



                <div class="card p-4">
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-8">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Classification</label>
                                <select name="classification" class="form-control">
                                    <option value="Program">Program</option>
                                    <option value="Project">Project</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Leader</label>
                                <input type="text" name="leader" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Team Members</label>
                                <input type="text" name="team_members" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">College/Campus</label>
                                <select name="location" class="form-control">
                                    <option value="">—</option>
                                    @foreach (['CAS', 'CBA', 'CET', 'CAFES', 'CCMADI', 'CED', 'GEPS', 'CALATRAVA CAMPUS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS', 'SAN ANDRES CAMPUS', 'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS', 'CAJIDIOCAN CAMPUS', 'SAN FERNANDO CAMPUS'] as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Target Agenda</label>
                                <select name="target_agenda" class="form-control">
                                    <option value="">Select Target Agenda</option>
                                    @foreach ($targetAgendas as $agenda)
                                        <option value="{{ $agenda->name }}">{{ $agenda->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            {{-- YES / NO FIELDS --}}
                            @php
                                $yesNo = [
                                    'in_house' => 'In-House',
                                    'revised_proposal' => 'Revised Proposal',
                                    'ntp' => 'NTP',
                                    'endorsement' => 'Endorsement',
                                    'proposal_presentation' => 'Proposal Presentation',
                                    'proposal_documents' => 'Proposal Documents',
                                    'program_proposal' => 'Program Proposal',
                                    'project_proposal' => 'Project Proposal',
                                    'moa_mou' => 'MOA/MOU',
                                    'activity_design' => 'Activity Design',
                                    'certificate_of_appearance' => 'Certificate of Appearance',
                                    'attendance_sheet' => 'Attendance Sheet',
                                ];
                            @endphp

                            @foreach ($yesNo as $name => $label)
                                <div class="col-md-4">
                                    <label class="form-label">{{ $label }}</label>
                                    <select name="{{ $name }}" class="form-control">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            @endforeach

                            <div class="col-md-4">
                                <label class="form-label">Approved Budget</label>
                                <input type="number" step="0.01" name="approved_budget" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Expenditure</label>
                                <input type="number" step="0.01" name="expenditure" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Fund Utilization Rate</label>
                                <input type="text" name="fund_utilization_rate" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Source of Funds</label>
                                <input type="text" name="source_of_funds" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Partner</label>
                                <input type="text" name="partner" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option>Ongoing</option>
                                    <option>Completed</option>
                                    <option>Cancelled</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Drive Link</label>
                                <input type="url" name="drive_link" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Documentation Report</label>
                                <input type="text" name="documentation_report" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="2"></textarea>
                            </div>

                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Save Proposal
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
