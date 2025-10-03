{{-- resources/views/admin/record_forms/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div id="content">
  @include('layouts.partials.topnav')

  <div class="midde_cont">
    <div class="container-fluid">
      <div class="row column_title">
        <div class="col-md-12">
          <div class="page_title">
            <h2>List of Records / Forms</h2>
          </div>
        </div>
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      
      <div class="row">
        <div class="col-md-12 text-end">
          <a href="{{ route('forms.create') }}" class="btn btn-primary" style="margin-left: 20px; margin-bottom: 10px;">
            <i class="fa fa-plus"></i> Add New Record / Form
          </a>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="white_shd full margin_bottom_30">
            <div class="full">
              <div class="table_section padding_infor_info">

                
                <div class="table-responsive-sm">
                  <table class="table table-bordered">
                    <thead class="thead-dark">
                      <tr>
                        <th>No.</th>
                        <th>Record Code</th>
                        <th>Record Title (Link)</th>
                        <th>Maintenance Period</th>
                        <th>Preservation Period</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($forms as $form)
                        <tr>
                          <td>{{ $form->display_order ?: $loop->iteration }}</td>
                          <td>{{ $form->record_code }}</td>
                          <td>
                            <a href="{{ $form->link_url }}" target="_blank" style="color:#007bff;">
                              {{ $form->title }}
                            </a>
                            @unless($form->is_active)
                              <span class="badge bg-secondary ms-1">inactive</span>
                            @endunless
                          </td>
                          <td>{{ $form->maintenance_years }} Years</td>
                          <td>{{ $form->preservation_years }} Years</td>
                          <td>{{ $form->remarks ?? '—' }}</td>
                          <td class="text-nowrap">
                            <a class="btn btn-sm btn-primary" href="{{ route('forms.edit', $form->id) }}">
                              <i class="fa fa-pencil"></i>
                            </a>
                           <form action="{{ route('forms.destroy', $form) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(event, this)">
  @csrf
  @method('DELETE')
  <button type="submit" class="btn btn-sm btn-danger">
    <i class="fa fa-trash"></i>
  </button>
</form>

                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="7" class="text-center text-muted">No records yet.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>

                  <p style="font-size: 13px; color: gray;">*Click on the blue title to fill out the corresponding Google Form.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // If you're using SweetAlert2 globally, replace with Swal.fire as you prefer
  function confirmDelete(e) {
    // basic browser confirm to keep this minimal; swap for SweetAlert2 if desired
    if (!confirm('Delete this record?')) {
      e.preventDefault();
      return false;
    }
    return true;
  }
</script>


<script>
  function confirmDelete(evt, formEl) {
    // Always stop the immediate submit
    if (evt) evt.preventDefault();

    // Fallback if Swal failed to load
    if (!window.Swal) {
      if (confirm('Delete this record? This cannot be undone.')) {
        formEl.submit();
      }
      return false;
    }

    Swal.fire({
      title: 'Delete this record?',
      text: 'This action cannot be undone.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Delete',
      cancelButtonText: 'Cancel',
      reverseButtons: true,
      focusCancel: true
    }).then((res) => {
      if (res.isConfirmed) {
        formEl.submit();
      }
    });

    // Always return false to prevent the native submit
    return false;
  }
</script>

@endpush
