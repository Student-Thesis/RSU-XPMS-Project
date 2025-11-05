{{-- resources/views/admin/record_forms/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')

        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title d-flex align-items-center justify-content-between gap-2 flex-wrap">
                            <h3 class="m-0">Forms / List of Records</h3>

                            <a href="{{ route('forms.create') }}" class="btn-primary btn"
                               style="margin-left: 20px;">
                                <i class="fa fa-plus"></i> Add New Record / Form
                            </a>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif

                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                            <div class="full">
                                <div class="table_section padding_infor_info">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered align-middle">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th style="width:70px;">No.</th>
                                                    <th style="width:140px;">Record Code</th>
                                                    <th>Record Title (Link)</th>
                                                    <th style="width:150px;">Maintenance Period</th>
                                                    <th style="width:150px;">Preservation Period</th>
                                                    <th>Remarks</th>
                                                    <th style="width:120px;">Actions</th>
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
                                                            @unless ($form->is_active)
                                                                <span class="badge bg-secondary ms-1">inactive</span>
                                                            @endunless
                                                        </td>
                                                        <td>{{ $form->maintenance_years }} Years</td>
                                                        <td>{{ $form->preservation_years }} Years</td>
                                                        <td>{{ $form->remarks ?? '—' }}</td>
                                                        <td class="text-nowrap">
                                                            <a class=" btn-warning text-white btn btn-sm"
                                                               href="{{ route('forms.edit', $form->id) }}">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <form action="{{ route('forms.destroy', $form) }}"
                                                                  method="POST"
                                                                  class="d-inline"
                                                                  onsubmit="return confirmDelete(event, this)">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-danger btn btn-sm">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted py-4">No records yet.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <p style="font-size: 13px; color: gray;">
                                            *Click on the blue title to fill out the corresponding Google Form.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- If you have pagination: --}}
                        {{-- {{ $forms->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(evt, formEl) {
            if (evt) evt.preventDefault();

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

            return false;
        }
    </script>
@endpush

@push('styles')
<style>
/* ✅ Compact uniform buttons across Bootstrap/AdminLTE overrides */
.btn-xs,
.btn-xs.btn,
.btn-xs.btn-sm {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 4px !important;

    /* Force smaller size */
    padding: 2px 6px !important;
    font-size: 11px !important;
    line-height: 1 !important;
    height: 22px !important;
    min-height: 22px !important;
    border-radius: 4px !important;
    vertical-align: middle !important;
}

.btn-xs i {
    font-size: 0.8em !important;
    line-height: 1 !important;
}

/* Ensure buttons don't expand in table cells */
.table td .btn-xs,
.table td .btn-xs i {
    margin: 0 !important;
}

/* Optional: make Add New button consistent too */
.page_title .btn-xs {
    font-weight: 500;
}
</style>
@endpush
