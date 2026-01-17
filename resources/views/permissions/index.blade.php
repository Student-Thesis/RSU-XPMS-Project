@extends('layouts.app')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-sm-6">
                    <h3 class="mb-0">Department Permissions</h3>
                </div>

              
                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                       <a href="{{ route('settings') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-gear me-1"></i> Back to Settings
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

            <div class="card">

                <div class="card-header">
                    <strong>
                        <i class="bi bi-people-fill me-1"></i>
                        Departments with Permissions
                    </strong>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Department</th>
                                <th class="text-center" style="width:160px;"># of Permission Rows</th>
                                <th class="text-center" style="width:160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $dept)
                                <tr>
                                    <td>{{ $dept->name }}</td>
                                    <td class="text-center">{{ $dept->permissions_count }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('departments.permissions.show', $dept) }}"
                                           class="btn btn-sm btn-warning text-white">
                                            <i class="bi bi-eye"></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle me-1"></i>
                                        No departments have permissions yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $departments->links() }}
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
