@extends('layouts.app')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-sm-6">
                    <h3 class="mb-0">
                        Department Permissions: {{ $department->name }}
                    </h3>
                </div>

                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('departments.permissions.edit', $department) }}"
                       class="btn btn-danger btn-sm">
                        <i class="bi bi-sliders me-1"></i>
                        Edit Group Permissions
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

            {{-- USERS UNDER THIS DEPARTMENT --}}
            <div class="card mt-3">

                <div class="card-header">
                    <strong>
                        <i class="bi bi-people-fill me-1"></i>
                        Users Under "{{ $department->name }}"
                    </strong>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-striped table-hover m-0 align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Department</th>
                                <th style="width: 160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $u)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $u->first_name }} {{ $u->last_name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->user_type }}</td>
                                    <td>{{ $u->department->name ?? '—' }}</td>
                                    <td>
                                        <a href="{{ route('departments.permissions.user.edit', $u->id) }}"
                                           class="btn btn-sm btn-warning text-white">
                                            <i class="bi bi-key me-1"></i>
                                            Edit User Permission
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle me-1"></i>
                                        No users found under this department.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

    {{-- SMALL UI TOUCHES --}}
    <style>
        .table td,
        .table th {
            vertical-align: middle !important;
        }

        .btn.btn-sm {
            font-size: 0.75rem;
        }
    </style>

@endsection
