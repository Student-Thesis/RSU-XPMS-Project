@extends('layouts.app')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-sm-6">
                    <h3 class="mb-0">Settings / Edit Classification</h3>
                </div>

                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('settings_classifications.index') }}"
                       class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to List
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">

            <p class="text-muted mt-2">
                Update classification details and availability.
            </p>

            <div class="card">

                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil-square me-1"></i>
                        Edit Classification
                    </h5>
                </div>

                <form method="POST"
                      action="{{ route('settings_classifications.update', $item) }}"
                      class="card-body">
                    @csrf
                    @method('PUT')

                    {{-- NAME --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', $item->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               required>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- ACTIVE TOGGLE --}}
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input"
                               type="checkbox"
                               role="switch"
                               id="is_active"
                               name="is_active"
                               {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Update
                        </button>

                        <a href="{{ route('settings_classifications.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>

    {{-- SMALL UI SAFETY --}}
    <style>
        .btn.btn-sm {
            font-size: 0.75rem;
        }
    </style>

@endsection
