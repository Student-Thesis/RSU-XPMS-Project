@extends('layouts.app')

@section('content')
<div id="content">
    @include('layouts.partials.topnav')

    <div class="midde_cont">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row column_title mb-4">
                <div class="col-md-12">
                    <div class="page_title d-flex align-items-center">
                        <i class="fa fa-cogs text-primary mr-2 fa-2x"></i>
                        <h2 class="mb-0">System Settings</h2>
                    </div>
                    <p class="text-muted mt-2">
                        Manage classifications, target agendas, and departmental permissions.
                    </p>
                </div>
            </div>

            <!-- Settings Cards -->
            <div class="row g-3">
                <!-- Department Permissions -->
                <div class="col-md-4">
                    <div class="card setting-card h-100">
                        <div class="card-body text-center">
                            <div class="icon-wrapper mb-3">
                                <i class="fa fa-users-cog fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title mb-2">Department Permissions</h5>
                            <p class="card-text text-muted small">
                                Control access and permission levels for each department.
                            </p>
                            <a href="{{ route('departments.permissions.index') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-shield-alt"></i> Manage Permissions
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Classifications -->
                <div class="col-md-4">
                    <div class="card setting-card h-100">
                        <div class="card-body text-center">
                            <div class="icon-wrapper mb-3">
                                <i class="fa fa-layer-group fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title mb-2">Classifications Settings</h5>
                            <p class="card-text text-muted small">
                                Define and manage project or program classifications.
                            </p>
                            <a href="{{ route('settings_classifications.index') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-cog"></i> Configure
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Target Agendas -->
                <div class="col-md-4">
                    <div class="card setting-card h-100">
                        <div class="card-body text-center">
                            <div class="icon-wrapper mb-3">
                                <i class="fa fa-bullseye fa-3x text-warning"></i>
                            </div>
                            <h5 class="card-title mb-2">Target Agenda Settings</h5>
                            <p class="card-text text-muted small">
                                Set and maintain strategic agenda targets for proposals.
                            </p>
                            <a href="{{ route('settings_target_agendas.index') }}" class="btn btn-warning btn-sm text-white">
                                <i class="fa fa-edit"></i> Edit Agendas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .setting-card {
            border: 2px solid #dee2e6; /* Stronger border */
            border-radius: 0.75rem;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        }

        .setting-card:hover {
            border-color: #007bff;
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .icon-wrapper i {
            border: 2px solid currentColor;
            border-radius: 50%;
            padding: 15px;
            width: 70px;
            height: 70px;
            line-height: 40px;
            background: #f8f9fa;
        }

        .page_title h2 {
            font-weight: 600;
        }
    </style>
</div>
@endsection
