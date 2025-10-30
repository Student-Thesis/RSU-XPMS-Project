{{-- resources/views/profiles/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div id="content">
    @include('layouts.partials.topnav')

    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title">
                        <h2>Profile</h2>
                    </div>
                </div>
            </div>

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

            <div class="row column1">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="white_shd full margin_bottom_30">
                        <div class="full graph_head">
                            <div class="heading1 margin_0">
                                <h2>User Profile</h2>
                            </div>
                        </div>
                        <div class="full padding_infor_info">

                            {{-- EDIT FORM --}}
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-lg-4 text-center mb-3">
                                        @php
                                            $u = $user ?? auth()->user();
                                            // if you saved like "avatars/xxx.jpg" in DB
                                            $avatarUrl = $u?->avatar_path
                                                ? asset($u->avatar_path)
                                                : asset('images/layout_img/default_profile.png');
                                        @endphp

                                        <img width="180" class="rounded-circle"
                                             src="{{ $avatarUrl }}"
                                             alt="Avatar"
                                             style="object-fit:cover;height:180px;">

                                        <div class="custom-file text-left mt-3">
                                            <input type="file" name="avatar" id="avatar" class="custom-file-input">
                                            <label class="custom-file-label" for="avatar">Choose new photo</label>
                                            <small class="form-text text-muted">JPG/PNG/WebP up to 3MB.</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text"
                                                   id="first_name"
                                                   name="first_name"
                                                   class="form-control"
                                                   value="{{ old('first_name', $user->first_name) }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text"
                                                   id="last_name"
                                                   name="last_name"
                                                   class="form-control"
                                                   value="{{ old('last_name', $user->last_name) }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text"
                                                   id="username"
                                                   name="username"
                                                   class="form-control"
                                                   value="{{ old('username', $user->username) }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email"
                                                   id="email"
                                                   name="email"
                                                   class="form-control"
                                                   value="{{ old('email', $user->email) }}"
                                                   readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text"
                                                   id="phone"
                                                   name="phone"
                                                   class="form-control"
                                                   value="{{ old('phone', $user->phone) }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="college">College / Department</label>
                                            <input type="text"
                                                   id="college"
                                                   name="college"
                                                   class="form-control"
                                                   value="{{ old('college', $user->college) }}">
                                            {{-- 
                                                If you later want to use the real department_id FK,
                                                replace this with a <select> and loop departments.
                                            --}}
                                        </div>

                                        <div class="form-group">
                                            <label for="about">About</label>
                                            <textarea id="about"
                                                      name="about"
                                                      rows="4"
                                                      class="form-control">{{ old('about', $user->about) }}</textarea>
                                        </div>

                                        <button class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save Changes
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>

            <div class="container-fluid">
                <div class="footer">
                    <p>Copyright © 2018 Designed by html.design. All rights reserved.<br><br>
                        Distributed By: <a href="https://themewagon.com/">ThemeWagon</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
