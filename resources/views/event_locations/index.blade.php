@extends('layouts.app')

@section('content')
<div id="content">
    @include('layouts.partials.topnav')

    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h2 class="m-0">Event Locations</h2>
                        <a href="{{ route('event-locations.create') }}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i> Add Location
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('event-locations.index') }}" class="row g-2 align-items-end mb-3">
                <div class="col-md-4">
                    <label><strong>Search:</strong></label>
                    <input type="text"
                           name="q"
                           value="{{ $q }}"
                           class="form-control"
                           placeholder="Search name, address, room...">
                </div>
            </form>

            <div class="white_shd full margin_bottom_30">
                <div class="full">
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:60px;">No.</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Room</th>
                                        <th style="width:100px;">Status</th>
                                        <th style="width:120px;" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($locations as $i => $loc)
                                        <tr>
                                            <td>{{ $locations->firstItem() + $i }}</td>
                                            <td>{{ $loc->name }}</td>
                                            <td>{{ $loc->address ?? '—' }}</td>
                                            <td>{{ $loc->room ?? '—' }}</td>
                                            <td>
                                                @if($loc->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('event-locations.edit', $loc) }}"
                                                   class="btn btn-warning btn-xs text-white">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('event-locations.destroy', $loc) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Delete this location?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No locations yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $locations->onEachSide(1)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
