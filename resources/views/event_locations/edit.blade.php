@extends('layouts.app')

@section('content')
<div id="content">

    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h2 class="m-0">Edit Event Location</h2>
                        <a href="{{ route('event-locations.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="white_shd full margin_bottom_30 mt-3">
                <div class="full padding_infor_info">
                    <form method="POST" action="{{ route('event-locations.update', $location) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" value="{{ old('name', $location->name) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address', $location->address) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Room / Area</label>
                            <input type="text" name="room" value="{{ old('room', $location->room) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" rows="2" class="form-control">{{ old('notes', $location->notes) }}</textarea>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_active"
                                   id="is_active"
                                   {{ old('is_active', $location->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-save"></i> Update Location
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
