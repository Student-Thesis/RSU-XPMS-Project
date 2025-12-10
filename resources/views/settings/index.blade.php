@extends('layouts.app')

@section('content')
    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0">System Settings</h3>
                </div>

            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">
            <p class="text-muted mt-2">
                Manage classifications, target agendas, and departmental permissions.
            </p>


            <!-- SETTINGS CARDS -->
            <div class="row g-4">

                {{-- Department Permissions --}}
                @auth
                    @if (Auth::user()->department_id == 1)
                        <div class="col-md-4">
                            <div class="card setting-card h-100">
                                <div class="card-body text-center">

                                    <div class="icon-wrapper text-primary mb-3">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div class="row">
                                        <h5 class="card-title mb-2">Department Permissions</h5>
                                    </div>


                                    <p class="card-text text-muted small">
                                        Control access and permission levels for each department.
                                    </p>

                                    <a href="{{ route('departments.permissions.index') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-shield-lock me-1"></i>
                                        Manage Permissions
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endif
                @endauth

                {{-- Classifications --}}
                <div class="col-md-4">
                    <div class="card setting-card h-100">
                        <div class="card-body text-center">

                            <div class="icon-wrapper text-success mb-3">
                                <i class="bi bi-list-check"></i>
                            </div>
                            <div class="row">
                                <h5 class="card-title">Classifications Settings</h5>
                            </div>


                            <p class="card-text text-muted small">
                                Define and manage project or program classifications.
                            </p>

                            <a href="{{ route('settings_classifications.index') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-sliders me-1"></i>
                                Configure
                            </a>

                        </div>
                    </div>
                </div>

                {{-- Target Agendas --}}
                <div class="col-md-4">
                    <div class="card setting-card h-100">
                        <div class="card-body text-center">

                            <div class="icon-wrapper text-warning mb-3">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <div class="row">
                                <h5 class="card-title mb-2">Target Agenda Settings</h5>
                            </div>


                            <p class="card-text text-muted small">
                                Set and maintain strategic agenda targets for proposals.
                            </p>

                            <a href="{{ route('settings_target_agendas.index') }}"
                                class="btn btn-warning btn-sm text-white">
                                <i class="bi bi-pencil-square me-1"></i>
                                Edit Agendas
                            </a>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- CUSTOM STYLES --}}
    <style>
        .setting-card {
            border: 1px solid #dee2e6;
            border-radius: 0.75rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            background: #fff;
        }

        .setting-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.15);
        }

        .icon-wrapper {
            width: 72px;
            height: 72px;
            margin: 0 auto;
            border-radius: 50%;
            border: 2px solid currentColor;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .icon-wrapper i {
            font-size: 2rem;
            line-height: 1;
        }

        .page_title h2 {
            font-weight: 600;
        }
    </style>

    </div>
@endsection
