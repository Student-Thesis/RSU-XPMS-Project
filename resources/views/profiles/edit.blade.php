@extends('layouts.app')

@section('content')
<div id="content">

    <div class="midde_cont p-3" style="width: 100% !important; max-width: 100% !important;">
        
        {{-- Page Title --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="m-0">Profile</h2>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- MAIN FULL-WIDTH CARD --}}
        <div class="white_shd margin_bottom_30 p-4" style="width: 100% !important;">
            <div class="heading1 mb-4">
                <h2>User Profile</h2>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- LEFT COLUMN – AVATAR --}}
                  <div class="col-lg-3 text-center mb-4">
    @php
        $u = $user ?? auth()->user();

        $avatarPath = $u && $u->avatar_path
            ? $u->avatar_path
            : 'images/layout_img/default_profile.png';

        // normalize leading slash
        $avatarPath = '/' . ltrim($avatarPath, '/');
    @endphp

    <img id="avatarPreview"
         src="{{ $basePath . $avatarPath }}"
         class="rounded-circle shadow-sm"
         width="180"
         height="180"
         style="object-fit: cover;">

    <div class="mt-3">
        <input type="file"
               name="avatar"
               id="avatar"
               class="form-control"
               accept="image/*">

        <small class="text-muted">JPG / PNG / WebP (Max 3MB)</small>
    </div>
</div>



                    {{-- RIGHT COLUMN – FORM FIELDS --}}
                    <div class="col-lg-9">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text"
                                       name="first_name"
                                       class="form-control"
                                       value="{{ old('first_name', $user->first_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text"
                                       name="last_name"
                                       class="form-control"
                                       value="{{ old('last_name', $user->last_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text"
                                       name="username"
                                       class="form-control"
                                       value="{{ old('username', $user->username) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       class="form-control"
                                       value="{{ $user->email }}"
                                       readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ old('phone', $user->phone) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">College / Department</label>
                                <input type="text"
                                       name="college"
                                       class="form-control"
                                       value="{{ old('college', $user->college) }}">
                            </div>

                        </div>

                        <button class="btn btn-primary mt-4">
                            <i class="fa fa-save"></i> Save Changes
                        </button>

                    </div>
                </div>

            </form>
        </div>

    </div>
</div>


{{-- IMAGE PREVIEW SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('avatar');
    const previewImg = document.getElementById('avatarPreview');

    fileInput.addEventListener('change', function () {
        const file = this.files?.[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = e => previewImg.src = e.target.result;
        reader.readAsDataURL(file);
    });
});
</script>

@endsection
