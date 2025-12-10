@extends('layouts.app')

@section('content')
<div id="content">

    <div class="midde_cont">
        <div class="container-fluid">

            <!-- Title -->
            <div class="page_title mb-3">
                <h3>Edit Permissions for: {{ $user->first_name }} {{ $user->last_name }}</h3>
                <p class="text-muted">User Type: {{ $user->user_type }}</p>
            </div>

            <!-- Alerts -->
            @if (session('ok'))
                <div class="alert alert-success">{{ session('ok') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            @php
                // Determine if user being edited is admin or root
                $isRootOrAdmin = in_array($user->user_type, ['admin', 'root']);
            @endphp

            <!-- Form Start -->
            <form action="{{ route('departments.permissions.user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <strong>User Permissions</strong>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-bordered table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width:200px;">Resource</th>
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

                                    {{-- 🔥 Hide entire Users row if user is NOT admin/root --}}
                                    @if ($isUsersResource && !$isRootOrAdmin)
                                        @continue
                                    @endif

                                    <tr>
                                        <td><strong>{{ ucfirst($res) }}</strong></td>

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
                        <button class="btn btn-success">
                            <i class="fa fa-save"></i> Save Permissions
                        </button>

                        <a href="{{ route('departments.permissions.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
