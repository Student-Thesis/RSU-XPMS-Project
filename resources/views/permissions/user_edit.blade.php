@extends('layouts.app')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-sm-7">
                    <h3 class="mb-0">
                        Edit Permissions for:
                        {{ $user->first_name }} {{ $user->last_name }}
                    </h3>
                    <p class="text-muted mb-0">
                        User Type: {{ $user->user_type }}
                    </p>
                </div>

                <div class="col-sm-5 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('departments.permissions.show', $user->department_id) }}"
                       class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to Department
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">

            {{-- Alerts --}}
            @if (session('ok'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('ok') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @php
                // Determine if user being edited is admin or root
                $isRootOrAdmin = in_array($user->user_type, ['admin', 'root']);
            @endphp

            {{-- FORM START --}}
            <form action="{{ route('departments.permissions.user.update', $user->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="card">

                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <strong>
                            <i class="bi bi-key me-1"></i>
                            User Permissions
                        </strong>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-bordered table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width:220px;">Resource</th>
                                    <th class="text-center">View</th>
                                    <th class="text-center">Create</th>
                                    <th class="text-center">Update</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($resources as $res)
                                    @php
                                        $isUsersResource = strtolower($res) === 'users';
                                    @endphp

                                    {{-- 🔒 Hide entire "Users" row if user is NOT admin/root --}}
                                    @if ($isUsersResource && !$isRootOrAdmin)
                                        @continue
                                    @endif

                                    <tr>
                                        <td>
                                            <strong>{{ ucfirst($res) }}</strong>
                                        </td>

                                        @foreach (['can_view','can_create','can_update','can_delete'] as $perm)
                                            <td class="text-center">
                                                <input type="checkbox"
                                                       name="permissions[{{ $res }}][{{ $perm }}]"
                                                       value="1"
                                                       {{ !empty($matrix[$res][$perm]) ? 'checked' : '' }}>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i>
                            Save Permissions
                        </button>

                        <a href="{{ route('departments.permissions.index') }}"
                           class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Cancel
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </div>

    {{-- SMALL UI TOUCHES --}}
    <style>
        .table td,
        .table th {
            vertical-align: middle !important;
        }

        .table thead th {
            white-space: nowrap;
        }

        .table td input[type="checkbox"] {
            width: 1.1rem;
            height: 1.1rem;
        }
    </style>

@endsection
