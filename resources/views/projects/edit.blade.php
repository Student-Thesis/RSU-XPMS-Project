@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')

        <!-- Main Content -->
        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="page_title">
                            <h3 class="m-0">Edit Proposal</h3>
                        </div>
                        <a href="{{ route('projects') }}" class="btn btn-secondary mb-3">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('projects.update', $project->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- Title --}}
                        <div class="col-md-8">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $project->title) }}"
                                   class="form-control"
                                   required>
                        </div>

                        {{-- Classification --}}
                        <div class="col-md-4">
                            <label class="form-label">Classification <span class="text-danger">*</span></label>
                            <select name="classification" class="form-control" required>
                                <option value="Program"
                                    {{ old('classification', $project->classification) === 'Program' ? 'selected' : '' }}>
                                    Program
                                </option>
                                <option value="Project"
                                    {{ old('classification', $project->classification) === 'Project' ? 'selected' : '' }}>
                                    Project
                                </option>
                            </select>
                        </div>

                        {{-- Leader --}}
                        <div class="col-md-6">
                            <label class="form-label">Leader</label>
                            <input type="text"
                                   name="leader"
                                   value="{{ old('leader', $project->leader) }}"
                                   class="form-control">
                        </div>

                        {{-- Team Members --}}
                        <div class="col-md-6">
                            <label class="form-label">Team Members</label>
                            <input type="text"
                                   name="team_members"
                                   value="{{ old('team_members', $project->team_members) }}"
                                   class="form-control">
                        </div>

                        {{-- College/Campus --}}
                        <div class="col-md-6">
                            <label class="form-label">College/Campus</label>
                            <select name="location" class="form-control">
                                <option value="">—</option>
                                @foreach (['CAS', 'CBA', 'CET', 'CAFES', 'CCMADI', 'CED', 'GEPS', 'CALATRAVA CAMPUS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS', 'SAN ANDRES CAMPUS', 'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS', 'CAJIDIOCAN CAMPUS', 'SAN FERNANDO CAMPUS'] as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('location', $project->location) === $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Target Agenda --}}
                        <div class="col-md-6">
                            <label class="form-label">Target Agenda</label>
                            <select name="target_agenda" class="form-select">
                                <option value="">Select Target Agenda</option>
                                @foreach ($targetAgendas as $agenda)
                                    <option value="{{ $agenda->name }}"
                                        {{ old('target_agenda', $project->target_agenda) === $agenda->name ? 'selected' : '' }}>
                                        {{ $agenda->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

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

                        {{-- Yes/No flags (same as Add modal) --}}
                        @foreach ($yesNo as $name => $label)
                            <div class="col-6 col-md-4">
                                <label class="form-label">{{ $label }}</label>
                                @php
                                    $value = old($name, $project->{$name});
                                @endphp
                                <select name="{{ $name }}" class="form-control">
                                    <option value="0" {{ (string)$value === '0' || is_null($value) ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ (string)$value === '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        @endforeach

                        {{-- Approved Budget --}}
                        <div class="col-md-4">
                            <label class="form-label">Approved Budget</label>
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   name="approved_budget"
                                   value="{{ old('approved_budget', $project->approved_budget) }}"
                                   class="form-control">
                        </div>

                        {{-- Expenditure --}}
                        <div class="col-md-4">
                            <label class="form-label">Expenditure</label>
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   name="expenditure"
                                   value="{{ old('expenditure', $project->expenditure) }}"
                                   class="form-control">
                        </div>

                        {{-- Fund Utilization Rate --}}
                        <div class="col-md-4">
                            <label class="form-label">Fund Utilization Rate</label>
                            <input type="text"
                                   name="fund_utilization_rate"
                                   value="{{ old('fund_utilization_rate', $project->fund_utilization_rate) }}"
                                   class="form-control">
                        </div>

                        {{-- Source of Funds --}}
                        <div class="col-md-6">
                            <label class="form-label">Source of Funds</label>
                            <input type="text"
                                   name="source_of_funds"
                                   value="{{ old('source_of_funds', $project->source_of_funds) }}"
                                   class="form-control">
                        </div>

                        {{-- Partner --}}
                        <div class="col-md-6">
                            <label class="form-label">Partner</label>
                            <input type="text"
                                   name="partner"
                                   value="{{ old('partner', $project->partner) }}"
                                   class="form-control">
                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control status-select">
                                @php
                                    $statusValue = old('status', $project->status);
                                @endphp
                                <option value="Ongoing"
                                    class="status-ongoing"
                                    {{ $statusValue === 'Ongoing' ? 'selected' : '' }}>
                                    Ongoing
                                </option>
                                <option value="Completed"
                                    class="status-completed"
                                    {{ $statusValue === 'Completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="Cancelled"
                                    class="status-cancelled"
                                    {{ $statusValue === 'Cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>
                        </div>

                        {{-- Code --}}
                        <div class="col-md-4">
                            <label class="form-label">Code</label>
                            <input type="text"
                                   name="code"
                                   value="{{ old('code', $project->code) }}"
                                   class="form-control">
                        </div>

                        {{-- Drive Link --}}
                        <div class="col-md-4">
                            <label class="form-label">Drive Link</label>
                            <input type="text"
                                   name="drive_link"
                                   value="{{ old('drive_link', $project->drive_link) }}"
                                   class="form-control">
                        </div>

                        {{-- Documentation Report --}}
                        <div class="col-md-12">
                            <label class="form-label">Documentation Report</label>
                            <input type="text"
                                   name="documentation_report"
                                   value="{{ old('documentation_report', $project->documentation_report) }}"
                                   class="form-control">
                        </div>

                        {{-- Remarks --}}
                        <div class="col-md-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2">{{ old('remarks', $project->remarks) }}</textarea>
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Update Proposal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Status Option Colors -->
    <style>
        .status-ongoing {
            background-color: #fff3cd !important;
            color: #856404 !important;
        }
        .status-completed {
            background-color: #d4edda !important;
            color: #155724 !important;
        }
        .status-cancelled {
            background-color: #f8d7da !important;
            color: #721c24 !important;
        }
    </style>
@endsection
