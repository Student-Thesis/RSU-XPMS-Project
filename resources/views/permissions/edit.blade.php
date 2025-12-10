@extends('layouts.app')

@section('content')
<div id="content">

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

            <form method="POST" action="{{ route('departments.permissions.update', $department) }}" class="card p-3">
                @csrf @method('PUT')

                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="min-width:180px;">Resource</th>
                                <th class="text-center">
                                    
                                    <input type="checkbox" class="form-check-input ms-1"
                                           onclick="toggleCol('can_view', this)">View
                                </th>
                                <th class="text-center">
                             
                                    <input type="checkbox" class="form-check-input ms-1"
                                           onclick="toggleCol('can_create', this)">       Create
                                </th>
                                <th class="text-center">
                              
                                    <input type="checkbox" class="form-check-input ms-1"
                                           onclick="toggleCol('can_update', this)">      Update
                                </th>
                                <th class="text-center">
                              
                                    <input type="checkbox" class="form-check-input ms-1"
                                           onclick="toggleCol('can_delete', this)">      Delete
                                </th>
                                <th class="text-center">Row “All”</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resources as $res)
                                <tr>
                                    <td class="text-capitalize fw-semibold">{{ $res }}</td>

                                    @foreach (['can_view','can_create','can_update','can_delete'] as $col)
                                        <td class="text-center">
                                            <input type="checkbox"
                                                   name="permissions[{{ $res }}][{{ $col }}]"
                                                   value="1"
                                                   class="form-check-input perm-checkbox {{ $col }} row-{{ $res }}"
                                                   @checked($matrix[$res][$col] ?? false)>
                                        </td>
                                    @endforeach

                                    {{-- Row “All” toggle --}}
                                    <td class="text-center">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               onclick="toggleRow('{{ $res }}', this)"
                                               title="Toggle all for {{ ucfirst($res) }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex gap-2">
                    <button class="btn btn-sm btn-primary" type="submit">
                        <i class="fa fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('departments.permissions.index') }}" class="btn btn-sm btn-warning ml-2">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript for toggling --}}
<script>
    function toggleCol(col, master) {
        document.querySelectorAll('.perm-checkbox.' + col).forEach(cb => {
            cb.checked = master.checked;
        });
    }
    function toggleRow(res, master) {
        document.querySelectorAll('.perm-checkbox.row-' + res).forEach(cb => {
            cb.checked = master.checked;
        });
    }
</script>
@endsection
