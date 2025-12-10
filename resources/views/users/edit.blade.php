@extends('layouts.app')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-sm-6">
                    <h3 class="mb-0">Edit User</h3>
                </div>

                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back to List
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
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title mb-0">User Details</h3>
                        </div>

                        <form id="userEditForm"
                              action="{{ route('users.update', $user->id) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                                                   value="{{ old('first_name', $user->first_name) }}"
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
                                                   value="{{ old('email', $user->email) }}"
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
                                                   value="{{ old('last_name', $user->last_name) }}"
                                                   required>
                                        </div>
                                    </div>

                                    {{-- Password (optional) + Confirm --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                New Password
                                                <small class="text-muted">(leave blank to keep current)</small>
                                            </label>
                                            <input type="password"
                                                   class="form-control"
                                                   name="password"
                                                   placeholder="Enter new password (optional)">
                                            <input type="password"
                                                   class="form-control mt-2"
                                                   name="password_confirmation"
                                                   placeholder="Confirm new password">
                                        </div>
                                    </div>

                                    {{-- Department / Role --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Department / Role <span class="text-danger">*</span></label>
                                            <select class="form-control" name="department_id" required>
                                                <option value="">-- Select Department / Role --</option>
                                                <option value="2" {{ old('department_id', $user->department_id) == 2 ? 'selected' : '' }}>
                                                    Manager
                                                </option>
                                                <option value="3" {{ old('department_id', $user->department_id) == 3 ? 'selected' : '' }}>
                                                    Coordinator
                                                </option>
                                                <option value="4" {{ old('department_id', $user->department_id) == 4 ? 'selected' : '' }}>
                                                    User
                                                </option>
                                            </select>
                                            @error('department_id')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select class="form-control" name="status" required>
                                                <option value="">-- Select Status --</option>
                                                <option value="Pending"
                                                    {{ old('status', $user->status) == 'Pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="Approved"
                                                    {{ old('status', $user->status) == 'Approved' ? 'selected' : '' }}>
                                                    Approved
                                                </option>
                                            </select>
                                            @error('status')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Avatar --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Avatar</label>
                                            <input type="file"
                                                   class="form-control"
                                                   name="avatar"
                                                   id="avatarInput"
                                                   accept="image/*">

                                            <div class="d-flex align-items-center gap-3 mt-2">
                                                {{-- Current avatar preview --}}
                                                <div class="avatar-preview d-inline-flex align-items-center justify-content-center">
                                                    @if ($user->avatar_path)
                                                        <img src="{{ asset($user->avatar_path) }}"
                                                             alt="avatar"
                                                             style="width:100%;height:100%;object-fit:cover;">
                                                    @else
                                                        <span class="small text-muted">No Avatar</span>
                                                    @endif
                                                </div>

                                                {{-- New selection preview --}}
                                                <div id="avatarPreview"
                                                     class="avatar-preview d-inline-flex align-items-center justify-content-center">
                                                    <span class="small text-muted">+ New</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

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

    // SweetAlert loading on submit
    document.getElementById('userEditForm').addEventListener('submit', function () {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Updating...',
                text: 'Please wait while we save your changes.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }
    });
</script>
@endpush
