<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentPermissionController extends Controller
{
    public function index()
    {
        // ✅ Only departments that have at least one permission
        $departments = Department::withCount('permissions')
            ->whereHas('permissions')
            ->orderBy('name')
            ->paginate(20);

        // Keep a list of resources if you want to show a legend or count per dept on index
        $resources = ['project','invoice','customer'];

        // view now expects $departments (NOT $permissions)
        return view('permissions.index', compact('departments', 'resources'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => ['required','exists:departments,id'],
            'resource'      => ['required','string','max:100'],
            'can_view'      => ['nullable','boolean'],
            'can_create'    => ['nullable','boolean'],
            'can_update'    => ['nullable','boolean'],
            'can_delete'    => ['nullable','boolean'],
        ]);

        foreach (['can_view','can_create','can_update','can_delete'] as $f) {
            $data[$f] = (bool) ($data[$f] ?? false);
        }

        DepartmentPermission::updateOrCreate(
            ['department_id' => $data['department_id'], 'resource' => $data['resource']],
            $data
        );

        return redirect()->route('departments.permissions.index')->with('ok', 'Permission saved.');
    }

    public function show(Department $department)
    {
        // ✅ Read-only matrix for “Show” page
        $resources = ['project','invoice','customer'];

        $existing = DepartmentPermission::where('department_id', $department->id)
            ->get()
            ->keyBy('resource');

        $matrix = [];
        foreach ($resources as $res) {
            $row = $existing->get($res);
            $matrix[$res] = [
                'can_view'   => (bool) optional($row)->can_view,
                'can_create' => (bool) optional($row)->can_create,
                'can_update' => (bool) optional($row)->can_update,
                'can_delete' => (bool) optional($row)->can_delete,
            ];
        }

        return view('permissions.show', compact('department','resources','matrix'));
    }

    public function edit(Department $department)
    {
        $resources = ['project','invoice','customer'];

        $existing = DepartmentPermission::where('department_id', $department->id)
            ->get()
            ->keyBy('resource');

        $matrix = [];
        foreach ($resources as $res) {
            $row = $existing->get($res);
            $matrix[$res] = [
                'can_view'   => (bool) optional($row)->can_view,
                'can_create' => (bool) optional($row)->can_create,
                'can_update' => (bool) optional($row)->can_update,
                'can_delete' => (bool) optional($row)->can_delete,
            ];
        }

        return view('permissions.edit', compact('department','resources','matrix'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'permissions' => ['array'], // permissions[resource][flag] = 1
        ]);

        $perms = $data['permissions'] ?? [];
        $resources = ['project','invoice','customer'];

        DB::transaction(function () use ($department, $perms, $resources) {
            foreach ($resources as $res) {
                $row = $perms[$res] ?? [];

                $flags = [
                    'can_view'   => (bool)($row['can_view']   ?? false),
                    'can_create' => (bool)($row['can_create'] ?? false),
                    'can_update' => (bool)($row['can_update'] ?? false),
                    'can_delete' => (bool)($row['can_delete'] ?? false),
                ];

                if (!array_filter($flags)) {
                    DepartmentPermission::where('department_id', $department->id)
                        ->where('resource', $res)
                        ->delete();
                } else {
                    DepartmentPermission::updateOrCreate(
                        ['department_id' => $department->id, 'resource' => $res],
                        $flags
                    );
                }
            }
        });

        return redirect()
            ->route('departments.permissions.edit', $department)
            ->with('ok', 'Permissions updated.');
    }

    public function destroy(DepartmentPermission $dept_permission)
    {
        $dept_permission->delete();
        return redirect()->route('departments.permissions.index')->with('ok', 'Permission deleted.');
    }
}
