@extends('layouts.app')

@section('content')
<div id="content">
    @include('layouts.partials.topnav')

    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title">
                        <h2>Department Permissions</h2>
                    </div>
                </div>
            </div>

            @if (session('ok'))
                <div class="alert alert-success">{{ session('ok') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <strong>Departments with Permissions</strong>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th class="text-center" style="width:160px;"># of Permission Rows</th>
                                <th style="width:220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $dept)
                                <tr>
                                    <td>{{ $dept->name }}</td>
                                    <td class="text-center">{{ $dept->permissions_count }}</td>
                                    <td>
                                        <a href="{{ route('departments.permissions.show', $dept) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i> Show
                                        </a>
                                        <a href="{{ route('departments.permissions.edit', $dept) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No departments have permissions yet.</td>
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
</div>
@endsection
