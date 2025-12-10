@extends('layouts.app')

@section('content')
    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0">Create New Proposals</h3>
                </div>
                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('projects') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">
            <div class="card p-4">
                <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        {{-- Title --}}
                        <div class="col-md-8">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                        </div>

                        {{-- Classification --}}
                        <div class="col-md-4">
                            <label class="form-label">Classification <span class="text-danger">*</span></label>
                            <select name="classification" class="form-control" required>
                                <option value="Program" {{ old('classification') == 'Program' ? 'selected' : '' }}>Program
                                </option>
                                <option value="Project" {{ old('classification') == 'Project' ? 'selected' : '' }}>Project
                                </option>
                            </select>
                        </div>

                        {{-- Leader --}}
                        <div class="col-md-6">
                            <label class="form-label">Leader</label>
                            <input type="text" name="leader" value="{{ old('leader') }}" class="form-control">
                        </div>

                        {{-- Team Members --}}
                        <div class="col-md-6">
                            <label class="form-label">Team Members</label>
                            <input type="text" name="team_members" value="{{ old('team_members') }}"
                                class="form-control">
                        </div>

                        {{-- College / Campus --}}
                        <div class="col-md-6">
                            <label class="form-label">College/Campus</label>
                            <select name="location" class="form-control">
                                <option value="">—</option>
                                @foreach (['CAS', 'CBA', 'CET', 'CAFES', 'CCMADI', 'CED', 'GEPS', 'CALATRAVA CAMPUS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS', 'SAN ANDRES CAMPUS', 'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS', 'CAJIDIOCAN CAMPUS', 'SAN FERNANDO CAMPUS'] as $opt)
                                    <option value="{{ $opt }}" {{ old('location') == $opt ? 'selected' : '' }}>
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
                                        {{ old('target_agenda') == $agenda->name ? 'selected' : '' }}>
                                        {{ $agenda->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        {{-- ===================== --}}
                        {{-- AGREEMENT FIELDS      --}}
                        {{-- ===================== --}}
                        <div class="col-md-6">
                            <label class="form-label">Organization Name</label>
                            <input type="text" name="organization_name" class="form-control"
                                value="{{ old('organization_name') }}" placeholder="Enter organization name">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date Signed</label>
                            <input type="date" name="date_signed" value="{{ old('date_signed') }}" class="form-control">
                        </div>

                        {{-- MOU File --}}
                        <div class="col-md-6">
                            <label class="form-label">MOU Document</label>
                            <input type="file" name="mou_path" class="form-control"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" data-max-size="10240">
                            <small class="text-muted">Max file size: 10 MB</small>
                        </div>

                        {{-- MOU Link --}}
                        <div class="col-md-6">
                            <label class="form-label">MOU G-Drive Link</label>
                            <input type="text" name="mou_link" class="form-control" value="{{ old('mou_link') }}"
                                placeholder="Enter G-Drive Link">
                        </div>

                        {{-- MOA File --}}
                        {{-- <div class="col-md-6">
                            <label class="form-label">Proposal Document</label>
                            <input type="file" name="moaFile" class="form-control"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" data-max-size="10240">
                            <small class="text-muted">Max file size: 10 MB</small>
                        </div> --}}

                        {{-- MOA Link --}}
                        {{-- <div class="col-md-6">
                            <label class="form-label">Proposal G-Drive Link</label>
                            <input type="text" name="moa_link" class="form-control"
                                value="{{ old('moa_link') }}" placeholder="Enter G-Drive Link">
                        </div> --}}



                        {{-- ===================== --}}
                        {{-- YES / NO STATUS FIELDS --}}
                        {{-- ===================== --}}
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
                                    <option value="0" {{ old($name) == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old($name) == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        @endforeach


                        {{-- Numeric + Misc. Fields --}}
                        <div class="col-md-4">
                            <label class="form-label">Approved Budget</label>
                            <input type="number" step="0.01" name="approved_budget"
                                value="{{ old('approved_budget') }}" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Expenditure</label>
                            <input type="number" step="0.01" name="expenditure" value="{{ old('expenditure') }}"
                                class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fund Utilization Rate</label>
                            <input type="text" name="fund_utilization_rate"
                                value="{{ old('fund_utilization_rate') }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Source of Funds</label>
                            <input type="text" name="source_of_funds" value="{{ old('source_of_funds') }}"
                                class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Partner</label>
                            <input type="text" name="partner" value="{{ old('partner') }}" class="form-control">
                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control status-select">
                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Ongoing" {{ old('status') == 'Ongoing' ? 'selected' : '' }}
                                    class="status-ongoing">Ongoing</option>
                                <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}
                                    class="status-completed">Completed</option>
                                <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}
                                    class="status-cancelled">Cancelled</option>
                            </select>
                        </div>

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


                        {{-- Code --}}
                        <div class="col-md-4">
                            <label class="form-label">Code</label>
                            <input type="text" name="code" value="{{ old('code') }}" class="form-control">
                        </div>

                        {{-- Drive Link --}}
                        {{-- <div class="col-md-4">
                            <label class="form-label">Drive Link</label>
                            <input type="url" name="drive_link" value="{{ old('drive_link') }}" class="form-control">
                        </div> --}}

                        {{-- Documentation --}}
                        <div class="col-md-12">
                            <label class="form-label">Documentation Report</label>
                            <input type="text" name="documentation_report" value="{{ old('documentation_report') }}"
                                class="form-control">
                        </div>

                        {{-- Remarks --}}
                        <div class="col-md-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2">{{ old('remarks') }}</textarea>
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
