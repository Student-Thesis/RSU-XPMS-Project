@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')
        <div class="midde_cont">
            <div class="container-fluid">
                <!-- Page Title -->
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h2 class="m-0">Settings → Classifications</h2>
                        </div>
                    </div>
                </div>

                {{-- Flash --}}
                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="m-0">Classifications List</h5>
                        <a href="{{ route('settings_classifications.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Add New Classification
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Active</th>
                                    <th class="text-end" style="width: 260px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->slug }}</td>
                                        <td>
                                            @if ($item->is_active)
                                                Yes
                                            @else
                                               No
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-1">
                                                {{-- Edit --}}
                                                <a href="{{ route('settings_classifications.edit', $item) }}"
                                                    class="btn btn-sm btn-warning text-white ml-1" style="margin:0; padding:5px;">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>

                                                {{-- Delete --}}
                                                <form action="{{ route('settings_classifications.destroy', $item) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Delete this classification?')" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger ml-1" style="margin:0; padding:5px;">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>

                                                {{-- Toggle --}}
                                                <form action="{{ route('settings_classifications.toggle', $item) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-secondary ml-1" style="margin:0; padding:5px;">
                                                        <i class="fa fa-toggle-on"></i>
                                                        {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No classifications yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Extra safety for outline themes --}}
    <style>
        /* In case your AdminLTE/Bootstrap theme makes outline buttons hard to see,
           this ensures text stays visible */
        .btn.btn-sm {
            font-size: 0.75rem;
        }
        .table td, .table th {
            vertical-align: middle !important;
        }
    </style>
@endsection
