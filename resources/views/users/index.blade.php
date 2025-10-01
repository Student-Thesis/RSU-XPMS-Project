@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')

        <!-- Main Content -->
        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title d-flex justify-content-between align-items-center">
                            <h2 style="margin-left: 10px;">User List</h2>

                            <a href="{{ route('users.create') }}" class="btn btn-outline-primary">
                                <i class="fa fa-plus"></i> Add New User
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <form class="filter-bar d-flex flex-wrap gap-2 mb-3" method="GET" action="{{ route('users.index') }}">
                    <div class="flex-grow-1" style="min-width:260px;">
                        <input type="text" class="form-control mr-2" name="q" value="{{ $q }}"
                            placeholder="Search name, email, phone..." />
                    </div>

                    <div>
                        <select name="role" class="form-control mr-2">
                            @foreach ($roles as $value => $label)
                                <option value="{{ $value }}" @selected($role === $value)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-secondary btn-xs mr-2" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-dark btn-xs">
                            <i class="fa fa-undo"></i>
                        </a>
                    </div>
                </form>


                <div class="white_shd full margin_bottom_30">
                    <div class="full">
                        <div class="table_section padding_infor_info">
                            <div class="table-responsive">
                                {{-- Optional: results summary --}}
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

                                <table class="table table-bordered custom-table">
                                    <thead>
                                        <tr>
                                            <th style="width:70px;">No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th style="width:180px;">Role</th>
                                            <th style="width:200px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $i => $u)
                                            <tr>
                                                {{-- numbering with pagination --}}
                                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $i + 1 }}</td>

                                                {{-- full name --}}
                                                <td>{{ $u->first_name . ' ' . $u->last_name }}</td>

                                                <td>{{ $u->email }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $u->user_type)) }}</td>

                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('users.edit', $u->id) }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('users.destroy', $u->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Delete this user?')">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No users found.</td>
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
        <!-- End Main Content -->
    </div>
@endsection
