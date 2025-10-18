@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')
        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h2>Settings → Classifications</h2>
                           
                        </div>
                    </div>
                </div>



                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('settings_classifications.create') }}" class="btn btn-primary btn-sm">
                            Add New Classification
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Active</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->slug }}</td>
                                        <td>
                                            <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                                {{ $item->is_active ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ route('settings_classifications.destroy', $item) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this classification?')">
                                                @csrf @method('DELETE')
                                                <a href="{{ route('settings_classifications.edit', $item) }}"
                                                    class="btn btn-sm btn-outline-primary me-1">
                                                    Edit
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                            <form action="{{ route('settings_classifications.toggle', $item) }}"
                                                method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm btn-outline-secondary ms-1">
                                                    {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No classifications yet.
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
@endsection
