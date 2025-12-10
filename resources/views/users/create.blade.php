@extends('layouts.app')

@section('content')
<div id="content">
     

    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title d-flex justify-content-between align-items-center">
                        <h2 style="margin-left: 10px;">Add New User</h2>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

               @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

            <div class="white_shd full margin_bottom_30">
                <div class="full">
                    <div class="form_section inner_information padding_infor_info">

                     

                        <form id="userCreateForm"
                              action="{{ route('users.store') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

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
                                            <option value="admin"           {{ old('user_type')=='admin'?'selected':'' }}>Admin</option>
                                            <option value="user"            {{ old('user_type')=='user'?'selected':'' }}>User</option>
                                            <option value="coordinator"          {{ old('user_type')=='coordinator'?'selected':'' }}>Coordinator</option>
                                            <option value="manager" {{ old('user_type')=='manager'?'selected':'' }}>Project Manager</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Avatar --}}
                                <div class="col-md-6">
                                    <label>Avatar</label>
                                    <input type="file" class="form-control-file" name="avatar" id="avatarInput" accept="image/*">
                                    <div id="avatarPreview"
                                         class="avatar-preview d-inline-flex align-items-center justify-content-center mt-2"
                                         style="width:80px;height:80px;border:1px dashed #aaa;border-radius:50%;overflow:hidden;">
                                        <span class="small text-muted">+ Avatar</span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save
                                </button>
                                {{-- Uncomment if you want a cancel button
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                                --}}
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
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
