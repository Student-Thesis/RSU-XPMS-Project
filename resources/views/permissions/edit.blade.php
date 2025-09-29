@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')

        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h1 class="mb-3">Edit Permissions — {{ $department->name }}</h1>
                        </div>
                    </div>
                </div>



                @if (session('ok'))
                    <div class="alert alert-success">{{ session('ok') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                {{-- Expect variables from controller:
         $department  -> Department model
         $resources   -> array of resource slugs, e.g. ['project','invoice','customer']
         $matrix      -> ['resource' => ['can_view'=>bool,'can_create'=>bool,'can_update'=>bool,'can_delete'=>bool] ]
    --}}

                <form method="POST" action="{{ route('departments.permissions.update', $department) }}" class="card p-3">
                    @csrf @method('PUT')

                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Resource</th>
                                    <th>
                                        <input type="checkbox" class="form-check-input ms-2"
                                            onclick="toggleCol('can_view', this)"> View 
                                    </th>
                                    <th>
                                        
                                        <input type="checkbox" class="form-check-input ms-2"
                                            onclick="toggleCol('can_create', this)">Create
                                    </th>
                                    <th>
                                       
                                        <input type="checkbox" class="form-check-input ms-2"
                                            onclick="toggleCol('can_update', this)"> Update
                                    </th>
                                    <th>
                                       
                                        <input type="checkbox" class="form-check-input ms-2"
                                            onclick="toggleCol('can_delete', this)"> Delete
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resources as $res)
                                    <tr>
                                        <td class="text-capitalize">{{ $res }}</td>
                                        @foreach (['can_view', 'can_create', 'can_update', 'can_delete'] as $col)
                                            <td>
                                                <input type="checkbox"
                                                    name="permissions[{{ $res }}][{{ $col }}]"
                                                    value="1"
                                                    class="form-check-input perm-checkbox {{ $col }}"
                                                    @checked($matrix[$res][$col] ?? false)>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                <input type="hidden" name="department_id" value="{{ $department->department_id }}">
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary mr-1" type="submit">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                        <a href="{{ route('departments.permissions.index') }}" class="btn btn-sm btn-warning">
                            Back to List
                        </a>
                    </div>
                </form>
            </div>

            <script>
                function toggleCol(col, master) {
                    document.querySelectorAll('.perm-checkbox.' + col).forEach(cb => {
                        cb.checked = master.checked;
                    });
                }
            </script>
        </div>
    </div>
@endsection
