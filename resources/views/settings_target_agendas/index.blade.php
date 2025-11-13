@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')
        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h2>Settings → Target Agendas</h2>
                            <small class="text-muted">Manage the selectable list used in forms (e.g., “Environmental
                                Awareness”).</small>
                        </div>
                        <a href="{{ route('settings_target_agendas.create') }}" class="btn btn-primary mb-2" style="margin:0; padding:5px;">
                            <i class="fa fa-plus"></i> New Agenda
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 36px;">#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Active</th>
                                    <th class="text-end" style="width: 220px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $idx => $item)
                                    <tr>
                                        <td>{{ $items->firstItem() + $idx }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-muted">{{ $item->slug }}</td>
                                        <td>
                                                {{ $item->is_active ? 'Yes' : 'No' }}
                                          
                                        </td>
                                        <td class="text-end">
    <a href="{{ route('settings_target_agendas.edit', $item) }}" 
       class="btn btn-sm btn-primary" style="margin:0; padding:5px;">
        <i class="fa fa-pencil"></i> Edit
    </a>
    <form action="{{ route('settings_target_agendas.destroy', $item) }}" 
          method="POST" class="d-inline"
          onsubmit="return confirm('Delete this target agenda?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" style="margin:0; padding:5px;">
            <i class="fa fa-trash"></i> Delete
        </button>
    </form>
</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No target agendas yet. Click <strong>New Agenda</strong> to add one.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($items instanceof \Illuminate\Contracts\Pagination\Paginator)
                        <div class="card-footer">
                            {{ $items->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
