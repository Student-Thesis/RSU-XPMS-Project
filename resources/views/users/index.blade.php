@extends('layouts.app')

@section('content')
    <div id="content">
         

        <div class="midde_cont">
            <div class="container-fluid">
                <!-- Page Title -->
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h2 class="m-0" style="margin-left: 10px;">User List</h2>

                            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New User
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="col-md-12">

                    <form method="GET" action="{{ route('users.index') }}" class="row align-items-end g-3 mb-3"
                        id="usersFilterForm">

                        {{-- Search --}}
                        <div class="col-md-3">
                            <label><strong>Search:</strong></label>
                            <input type="text" id="usersSearchInput" name="q" value="{{ $q }}"
                                class="form-control" placeholder="Search name, email, phone...">
                        </div>

                        {{-- Role Filter --}}
                        <div class="col-md-3">
                            <label><strong>Filter by Role:</strong></label>
                            <select name="role" id="usersRoleFilter" class="form-control">
                                @foreach ($roles as $value => $label)
                                    <option value="{{ $value }}" @selected($role === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- No buttons — auto filtered --}}
                    </form>
                </div>

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
                                            <th>Status</th>
                                            <th class="text-center actions">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $i => $u)
                                            <tr>
                                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $i + 1 }}</td>
                                                <td>{{ $u->first_name . ' ' . $u->last_name }}</td>
                                                <td>{{ $u->email }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $u->user_type)) }}</td>
                                                <td>{{ $u->status }}</td>
                                                <td class="text-center actions">
                                                    <div class="d-inline-flex">
                                                        <a href="{{ route('users.edit', $u->id) }}"
                                                            class="btn btn-warning btn-xs text-white" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('users.destroy', $u->id) }}" method="POST"
                                                            onsubmit="return confirm('Delete this user?')" class="m-0 p-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-xs"
                                                                title="Delete">
                                                                <i class="fa fa-trash"></i>
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
        /* Auto-width for Action column */
        .users-table td.actions,
        .users-table th.actions {
            white-space: nowrap;
            width: 1%;
        }

        .users-table .btn-xs {
            padding: 3px 6px;
            font-size: 0.75rem;
            line-height: 1;
        }

        .users-table .d-inline-flex {
            gap: 4px;
        }

        /* extra small button, but centered */
        /* ✅ Uniform small buttons */
        .btn-xs {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            /* space between icon and text */
            padding: 3px 8px !important;
            font-size: 0.75rem !important;
            line-height: 1 !important;
            border-radius: 3px !important;
            height: 26px !important;
            /* fixed uniform height */
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('usersFilterForm');
            const searchInput = document.getElementById('usersSearchInput');
            const roleSelect = document.getElementById('usersRoleFilter');
            let searchTimeout = null;

            // Auto-submit on typing (debounce)
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => form.submit(), 500);
                });

                // Submit immediately on Enter
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.submit();
                    }
                });
            }

            // Auto-submit on dropdown change
            if (roleSelect) {
                roleSelect.addEventListener('change', () => form.submit());
            }
        });
    </script>
@endsection
