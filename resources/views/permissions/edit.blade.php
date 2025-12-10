@extends('layouts.app')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-sm-7">
                    <h3 class="mb-0">
                        Edit Group Permissions — {{ $department->name }}
                    </h3>
                    <p class="text-muted mb-0">
                        Configure default permissions for this department.
                    </p>
                </div>

                <div class="col-sm-5 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('departments.permissions.index') }}"
                       class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to Department List
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

            <form method="POST"
                  action="{{ route('departments.permissions.update', $department) }}"
                  class="card">
                @csrf
                @method('PUT')

                <div class="card-header">
                    <strong>
                        <i class="bi bi-sliders me-1"></i>
                        Permission Matrix
                    </strong>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="min-width: 180px;">Resource</th>

                                    <th class="text-center">
                                        <input type="checkbox"
                                               class="form-check-input ms-1"
                                               onclick="toggleCol('can_view', this)">
                                        <span class="ms-1">View</span>
                                    </th>

                                    <th class="text-center">
                                        <input type="checkbox"
                                               class="form-check-input ms-1"
                                               onclick="toggleCol('can_create', this)">
                                        <span class="ms-1">Create</span>
                                    </th>

                                    <th class="text-center">
                                        <input type="checkbox"
                                               class="form-check-input ms-1"
                                               onclick="toggleCol('can_update', this)">
                                        <span class="ms-1">Update</span>
                                    </th>

                                    <th class="text-center">
                                        <input type="checkbox"
                                               class="form-check-input ms-1"
                                               onclick="toggleCol('can_delete', this)">
                                        <span class="ms-1">Delete</span>
                                    </th>

                                    <th class="text-center" style="min-width: 120px;">
                                        Row “All”
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($resources as $res)
                                    <tr>
                                        <td class="text-capitalize fw-semibold">
                                            {{ $res }}
                                        </td>

                                        @foreach (['can_view','can_create','can_update','can_delete'] as $col)
                                            <td class="text-center">
                                                <input type="checkbox"
                                                       name="permissions[{{ $res }}][{{ $col }}]"
                                                       value="1"
                                                       class="form-check-input perm-checkbox {{ $col }} row-{{ $res }}"
                                                       @checked($matrix[$res][$col] ?? false)>
                                            </td>
                                        @endforeach

                                        {{-- Row “All” toggle --}}
                                        <td class="text-center">
                                            <input type="checkbox"
                                                   class="form-check-input"
                                                   onclick="toggleRow('{{ $res }}', this)"
                                                   title="Toggle all for {{ ucfirst($res) }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2 justify-content-end">
                    <button class="btn btn-sm btn-primary" type="submit">
                        <i class="bi bi-save me-1"></i>
                        Save Changes
                    </button>

                    <a href="{{ route('departments.permissions.index') }}"
                       class="btn btn-sm btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

    {{-- JavaScript for toggling --}}
    <script>
        function toggleCol(col, master) {
            document.querySelectorAll('.perm-checkbox.' + col).forEach(cb => {
                cb.checked = master.checked;
            });
        }

        function toggleRow(res, master) {
            document.querySelectorAll('.perm-checkbox.row-' + res).forEach(cb => {
                cb.checked = master.checked;
            });
        }
    </script>

    {{-- Small UI polish --}}
    <style>
        .table thead th {
            white-space: nowrap;
        }

        .table td input[type="checkbox"],
        .table th input[type="checkbox"] {
            width: 1.05rem;
            height: 1.05rem;
        }
    </style>

@endsection
