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
                            <h3>Create New Proposal</h3>
                        </div>
                        <a href="{{ route('projects') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>



                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Classification</label>
                        <select name="classification" class="form-control">
                            <option value="Program" {{ old('classification') === 'Program' ? 'selected' : '' }}>Program
                            </option>
                            <option value="Project" {{ old('classification') === 'Project' ? 'selected' : '' }}>Project
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">College/Campus</label>
                        <input type="text" name="location" value="{{ old('location') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Team Members</label>
                        <textarea name="team_members" rows="2" class="form-control">{{ old('team_members') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Target Agenda</label>
                        <input type="text" name="target_agenda" value="{{ old('target_agenda') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Approved Budget</label>
                        <input type="number" name="approved_budget" value="{{ old('approved_budget') }}"
                            class="form-control" min="0" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="Ongoing" {{ old('status') === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="Cancelled" {{ old('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Save Proposal
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
