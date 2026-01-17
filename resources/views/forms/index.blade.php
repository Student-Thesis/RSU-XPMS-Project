{{-- resources/views/admin/record_forms/index.blade.php --}}
@extends('layouts.app')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <h3 class="mb-0">Forms / List of Records</h3>
                </div>
                <div class="col-sm-4 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('forms.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-1"></i> Add New Record / Form
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3 mb-0" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="recordFormsTable"
                               class="table table-bordered table-striped table-sm align-middle records-table">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width:70px;">No.</th>
                                    <th style="width:140px;">Record Code</th>
                                    <th>Record Title (Link)</th>
                                    <th style="width:150px;">Maintenance Period</th>
                                    <th style="width:150px;">Preservation Period</th>
                                    <th>Remarks</th>
                                    <th class="text-center" style="width:120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($forms as $form)
                                    <tr>
                                        <td>{{ $form->display_order ?: $loop->iteration }}</td>
                                        <td>{{ $form->record_code }}</td>
                                        <td>
                                            <a href="{{ $form->link_url }}"
                                               target="_blank"
                                               class="text-primary text-decoration-underline">
                                                {{ $form->title }}
                                            </a>
                                            @unless ($form->is_active)
                                                <span class="badge bg-secondary ms-1">inactive</span>
                                            @endunless
                                        </td>
                                        <td>{{ $form->maintenance_years }} Years</td>
                                        <td>{{ $form->preservation_years }} Years</td>
                                        <td>{{ $form->remarks ?? '—' }}</td>
                                        <td class="text-nowrap text-center">
                                            <a class="btn btn-warning btn-xs text-white me-1"
                                               href="{{ route('forms.edit', $form->id) }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                           <form action="{{ route('forms.destroy', $form->id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(event, this)">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-xs">
        <i class="bi bi-trash"></i>
    </button>
</form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            No records yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <p class="mt-2 mb-0" style="font-size: 13px; color: gray;">
                            * Click on the blue title to fill out the corresponding Google Form.
                        </p>
                    </div>

                    {{-- If you have pagination: --}}
                    {{-- <div class="mt-3">{{ $forms->links() }}</div> --}}

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

        function setYesNoColor(el) {
    el.classList.remove('yes', 'no');

    const isYes = el.value === '1';
    if (isYes) {
        el.classList.add('yes');
    } else {
        el.classList.add('no');
    }
}

    </script>
@endpush

@push('styles')
<style>
    /* Table layout */
    #recordFormsTable,
    .records-table {
        table-layout: auto !important;
        width: 100%;
        font-size: 0.8rem;
    }

    #recordFormsTable th,
    #recordFormsTable td {
        white-space: nowrap;
        padding: 4px 8px !important;
        vertical-align: middle !important;
    }

    #recordFormsTable thead th {
        text-align: center;
    }

    /* Extra small buttons – consistent across app */
    .btn-xs {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 2px 6px;
        font-size: 0.75rem;
        line-height: 1;
        border-radius: 4px;
    }
      .proposal-table td,
    .proposal-table th {
        padding: .35rem .5rem !important;
    }

    .inline-cell {
        cursor: text;
    }

    /* Base style for all Yes/No selects */
    .dropdown-yesno {
        font-weight: 600;
        border-width: 1px;
        transition: background-color .2s ease, color .2s ease, border-color .2s ease;
    }

    /* YES = green */
    .dropdown-yesno.yes {
        background-color: #d1f7d6;   /* light green */
        color: #155724;              /* dark green text */
        border-color: #198754;       /* bootstrap success */
    }

    /* NO = red */
    .dropdown-yesno.no {
        background-color: #f8d7da;   /* light red */
        color: #842029;              /* dark red text */
        border-color: #dc3545;       /* bootstrap danger */
    }


    .btn-xs i {
        font-size: 0.8em !important;
        line-height: 1 !important;
        margin: 0 !important;
    }
</style>
@endpush
