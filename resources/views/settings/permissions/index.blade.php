{{-- resources/views/departments/permissions.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">
      Edit Permissions — <span class="text-primary">{{ $department->name }}</span>
    </h1>
    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
      <i class="fa fa-arrow-left"></i> Back
    </a>
  </div>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
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

  <form method="POST" action="{{ route('departments.permissions.update', $department) }}">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Permissions</span>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-check-all">Check all</button>
          <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-uncheck-all">Uncheck all</button>
        </div>
      </div>

      <div class="card-body">
        @if($permissions->isEmpty())
          <p class="text-muted mb-0">No permissions defined yet.</p>
        @else
          <div class="row">
            @foreach($permissions as $perm)
              <div class="col-md-4 mb-2">
                <div class="form-check">
                  <input
                    class="form-check-input perm-checkbox"
                    type="checkbox"
                    name="permissions[]"
                    id="perm-{{ $perm->id }}"
                    value="{{ $perm->id }}"
                    {{ in_array($perm->id, old('permissions', $current), true) ? 'checked' : '' }}
                  >
                  <label class="form-check-label" for="perm-{{ $perm->id }}">
                    <span class="fw-semibold">{{ $perm->name }}</span>
                    <small class="text-muted d-block">{{ $perm->slug }}</small>
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <div class="card-footer d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-primary">
          Save Changes
        </button>
        <a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
      </div>
    </div>
  </form>
</div>

{{-- Tiny helpers --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const all = document.querySelectorAll('.perm-checkbox');
  document.getElementById('btn-check-all')?.addEventListener('click', () => {
    all.forEach(cb => cb.checked = true);
  });
  document.getElementById('btn-uncheck-all')?.addEventListener('click', () => {
    all.forEach(cb => cb.checked = false);
  });
});
</script>
@endsection
