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
                        <h2 class="m-0" style="margin-left: 10px;">User List</h2>

                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-xs">
                            <i class="fa fa-plus"></i> Add New User
                        </a>
                    </div>
                </div>
            </div>

            {{-- Filter Bar --}}
            <form class="filter-bar d-flex flex-wrap gap-2 mb-3 align-items-center"
                  method="GET"
                  action="{{ route('users.index') }}">
                <div class="flex-grow-1" style="min-width:260px;">
                    <input type="text"
                           class="form-control form-control-sm"
                           name="q"
                           value="{{ $q }}"
                           placeholder="Search name, email, phone..." />
                </div>

                <div>
                    <select name="role" class="form-control form-control-sm">
                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}" @selected($role === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-1">
                    <button class="btn btn-secondary btn-xs ml-1" type="submit" title="Search">
                        <i class="fa fa-search"></i> Search
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-dark btn-xs ml-1" title="Reset">
                        <i class="fa fa-undo"></i> Cancel
                    </a>
                </div>
            </form>

            <!-- Table Card -->
            <div class="white_shd full margin_bottom_30">
                <div class="full">
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive">

                            {{-- Results summary --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="small text-muted">
                                    @if ($users->total() > 0)
                                        Showing
                                        {{ ($users->currentPage() - 1) * $users->perPage() + 1 }}
                                        –
                                        {{ ($users->currentPage() - 1) * $users->perPage() + $users->count() }}
                                        of {{ $users->total() }} users
                                    @else
                                        No results
                                    @endif
                                </div>
                            </div>

                            <table class="table table-bordered table-striped table-hover mb-0 users-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:70px;">No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th style="width:160px;">Role</th>
                                        <th style="width:200px;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $i => $u)
                                        <tr>
                                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $i + 1 }}</td>
                                            <td>{{ $u->first_name . ' ' . $u->last_name }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $u->user_type)) }}</td>
                                            <td class="text-center">
                                                <div class="d-inline-flex gap-1">
                                                    <a href="{{ route('users.edit', $u->id) }}"
                                                       class="btn btn-warning btn-xs text-white">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>

                                                    <form action="{{ route('users.destroy', $u->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Delete this user?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-danger btn-xs ml-1">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                No users found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            <div class="mt-3">
                                {{ $users->onEachSide(1)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /white_shd -->
        </div>
    </div>
</div>

<style>
    /* extra small button, but centered */
 /* ✅ Uniform small buttons */
.btn-xs {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;                /* space between icon and text */
    padding: 3px 8px !important;
    font-size: 0.75rem !important;
    line-height: 1 !important;
    border-radius: 3px !important;
    height: 26px !important; /* fixed uniform height */
}

/* ensure icons align perfectly with text */
.btn-xs i {
    line-height: 1;
    font-size: 0.85em;
    margin-top: 0;
}

    /* small controls */
    .form-control-sm {
        height: calc(1.5em + 0.5rem + 2px);
        font-size: 0.78rem;
    }

    .users-table td,
    .users-table th {
        vertical-align: middle !important;
    }

    .users-table .badge {
        font-size: 0.7rem;
    }

    @media (max-width: 767.98px) {
        .users-table th:nth-child(3),
        .users-table td:nth-child(3) {
            word-break: break-all;
        }
    }
</style>
@endsection
