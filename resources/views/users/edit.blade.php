@extends('layouts.app')

@section('content')
<div id="content">
    @include('layouts.partials.topnav')

    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title d-flex justify-content-between align-items-center">
                        <h2 style="margin-left: 10px;">Edit User</h2>
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

                        <form id="userEditForm"
                              action="{{ route('users.update', $user->id) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                                        <label>New Password <small class="text-muted">(leave blank to keep current)</small></label>
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

                               {{-- Role --}}
<div class="col-md-6">
    <div class="form-group">
        <label>User Role <span class="text-danger">*</span></label>
        <select class="form-control" name="user_type" required>
            <option value="">-- Select Role --</option>
            @foreach($roles as $r)
                <option value="{{ $r }}" {{ old('user_type', $user->user_type) == $r ? 'selected' : '' }}>
                    {{ ucfirst($r) }}
                </option>
            @endforeach
        </select>
    </div>
</div>


                                {{-- Avatar --}}
                                <div class="col-md-6">
                                    <label>Avatar</label>
                                    <input type="file" class="form-control-file" name="avatar" id="avatarInput" accept="image/*">

                                    <div class="d-flex align-items-center gap-3 mt-2">
                                        {{-- Current avatar preview --}}
                                        <div class="d-inline-flex align-items-center justify-content-center"
                                             style="width:80px;height:80px;border:1px dashed #aaa;border-radius:50%;overflow:hidden;">
                                            @if($user->avatar_path)
                                                <img src="{{ asset($user->avatar_path) }}"
                                                     alt="avatar"
                                                     style="width:100%;height:100%;object-fit:cover;">
                                            @else
                                                <span class="small text-muted">No Avatar</span>
                                            @endif
                                        </div>

                                        {{-- New selection preview --}}
                                        <div id="avatarPreview"
                                             class="avatar-preview d-inline-flex align-items-center justify-content-center"
                                             style="width:80px;height:80px;border:1px dashed #aaa;border-radius:50%;overflow:hidden;">
                                            <span class="small text-muted">+ New</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
