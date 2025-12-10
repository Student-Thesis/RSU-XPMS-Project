@extends('layouts.app')

@section('content')
<div id="content">

    <div class="midde_cont">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title d-flex justify-content-between align-items-center">
                        <h2>Department Permissions: {{ $department->name }}</h2>

                        <a href="{{ route('departments.permissions.edit', $department) }}"
                           class="btn btn-danger btn-sm">
                            <i class="fa fa-edit"></i> Edit Group Permissions
                        </a>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if (session('ok'))
                <div class="alert alert-success">{{ session('ok') }}</div>
            @endif

            <!-- Users in this Department -->
<div class="card mt-4">
    <div class="card-header">
        <strong>Users Under "{{ $department->name }}"</strong>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped m-0 align-middle">
            <thead class="table-secondary">
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Department</th>
                    <th style="width:120px;">Actions</th>
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
       class="btn btn-sm btn-warning">
        <i class="fa fa-edit"></i> Edit User Permission
    </a>
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
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
</div>

@endsection
