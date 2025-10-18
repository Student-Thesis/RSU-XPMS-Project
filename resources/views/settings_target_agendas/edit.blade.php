@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')
        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h2>Edit Target Agenda</h2>
                        </div>
                        <a href="{{ route('settings_target_agendas.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>




                @if ($errors->any())
                    <div class="alert alert-danger">
                        <div class="fw-bold mb-1">Please fix the following:</div>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('settings_target_agendas.update', $settings_target_agenda) }}"
                    class="card p-3">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $settings_target_agenda->name) }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="e.g. Environmental Awareness" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                            {{ old('is_active', $settings_target_agenda->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('settings_target_agendas.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
