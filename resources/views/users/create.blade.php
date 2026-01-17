@extends('layouts.app')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-sm-6">
                    <h3 class="mb-0">Add New User</h3>
                </div>

                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title mb-0">User Details</h3>
                        </div>

                        <form id="userCreateForm"
                              action="{{ route('users.store') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <div class="row">

                                    {{-- First Name --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="first_name"
                                                   placeholder="Enter first name"
                                                   value="{{ old('first_name') }}"
                                                   required>
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   placeholder="Enter email"
                                                   value="{{ old('email') }}"
                                                   required>
                                        </div>
                                    </div>

                                    {{-- Last Name --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="last_name"
                                                   placeholder="Enter last name"
                                                   value="{{ old('last_name') }}"
                                                   required>
                                        </div>
                                    </div>

                                    {{-- Password + Confirm --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password <span class="text-danger">*</span></label>
                                            <input type="password"
                                                   class="form-control"
                                                   name="password"
                                                   placeholder="Enter password"
                                                   required>

                                            <input type="password"
                                                   class="form-control mt-2"
                                                   name="password_confirmation"
                                                   placeholder="Confirm password"
                                                   required>
                                        </div>
                                    </div>

                                    {{-- Role --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>User Role <span class="text-danger">*</span></label>
                                            <select class="form-control" name="user_type" required>
                                                <option value="">-- Select Role --</option>
                                                <option value="admin"       {{ old('user_type')=='admin'?'selected':'' }}>Admin</option>
                                                <option value="user"        {{ old('user_type')=='user'?'selected':'' }}>User</option>
                                                <option value="coordinator" {{ old('user_type')=='coordinator'?'selected':'' }}>Coordinator</option>
                                                <option value="manager"     {{ old('user_type')=='manager'?'selected':'' }}>Project Manager</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Avatar --}}
                                    <div class="col-md-6">
                                        <label>Avatar</label>
                                        <input type="file"
                                               class="form-control"
                                               name="avatar"
                                               id="avatarInput"
                                               accept="image/*">

                                        <div id="avatarPreview"
                                             class="avatar-preview d-inline-flex align-items-center justify-content-center mt-2">
                                            <span class="small text-muted">+ Avatar</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Save
                                </button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Styles --}}
    <style>
        .avatar-preview {
            width: 80px;
            height: 80px;
            border: 1px dashed #aaa;
            border-radius: 50%;
            overflow: hidden;
            background-color: #f8f9fa;
        }
    </style>

@endsection

@push('scripts')
<script>
(function () {
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');

    // Live avatar preview
    avatarInput?.addEventListener('change', function (e) {
        const file = e.target.files && e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (evt) {
            avatarPreview.innerHTML = '';
            const img = document.createElement('img');
            img.src = evt.target.result;
            img.alt = 'avatar';
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            avatarPreview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
})();
</script>
@endpush
