@extends('layouts.app')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-sm-6">
                    <h3 class="mb-0">Settings / Classifications</h3>
                </div>

                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('settings_classifications.create') }}"
                       class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>
                        Add Classification
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">

            <p class="text-muted mt-2">
                Manage available classifications used across projects and programs.
            </p>

            {{-- Flash --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-check me-1"></i>
                        Classifications List
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="text-end" style="width: 280px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>

                                    <td>
                                        @if ($item->is_active)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-x-circle me-1"></i>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">

                                            {{-- Edit --}}
                                            <a href="{{ route('settings_classifications.edit', $item) }}"
                                               class="btn btn-sm btn-warning text-white">
                                                <i class="bi bi-pencil-square"></i>
                                                Edit
                                            </a>

                                            {{-- Toggle --}}
                                            <form action="{{ route('settings_classifications.toggle', $item) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-sm btn-secondary">
                                                    <i class="bi bi-toggle-{{ $item->is_active ? 'on' : 'off' }}"></i>
                                                    {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>

                                            {{-- Delete --}}
                                            <form action="{{ route('settings_classifications.destroy', $item) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Delete this classification?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle me-1"></i>
                                        No classifications found.
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

    {{-- SMALL UI SAFETY --}}
    <style>
        .table td,
        .table th {
            vertical-align: middle !important;
        }

        .btn.btn-sm {
            font-size: 0.75rem;
        }
    </style>

@endsection
