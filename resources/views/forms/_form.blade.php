{{-- resources/views/admin/record_forms/partials/form-fields.blade.php --}}
@php
  $f = $form ?? null;
@endphp

<div class="row g-3">
  <div class="col-md-3">
    <label class="form-label">Record Code <span class="text-danger">*</span></label>
    <input type="text" name="record_code" class="form-control"
           value="{{ old('record_code', $f->record_code ?? '') }}" required>
    @error('record_code') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Title <span class="text-danger">*</span></label>
    <input type="text" name="title" class="form-control"
           value="{{ old('title', $f->title ?? '') }}" required>
    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-3">
    <label class="form-label">Display Order</label>
    <input type="number" name="display_order" class="form-control" min="0"
           value="{{ old('display_order', $f->display_order ?? 0) }}">
    @error('display_order') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-12">
    <label class="form-label">Link URL <span class="text-danger">*</span></label>
    <input type="url" name="link_url" class="form-control"
           value="{{ old('link_url', $f->link_url ?? '') }}" required>
    @error('link_url') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-3">
    <label class="form-label">Maintenance (Years) <span class="text-danger">*</span></label>
    <input type="number" name="maintenance_years" class="form-control" min="0" max="100"
           value="{{ old('maintenance_years', $f->maintenance_years ?? 5) }}" required>
    @error('maintenance_years') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-3">
    <label class="form-label">Preservation (Years) <span class="text-danger">*</span></label>
    <input type="number" name="preservation_years" class="form-control" min="0" max="100"
           value="{{ old('preservation_years', $f->preservation_years ?? 5) }}" required>
    @error('preservation_years') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-4">
    <label class="form-label">Remarks</label>
    <input type="text" name="remarks" class="form-control"
           value="{{ old('remarks', $f->remarks ?? 'IN-USE') }}">
    @error('remarks') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="col-md-2 d-flex align-items-end">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="is_active" value="1"
             id="is_active" {{ old('is_active', $f->is_active ?? true) ? 'checked' : '' }}>
      <label class="form-check-label" for="is_active">Active</label>
    </div>
  </div>
</div>
