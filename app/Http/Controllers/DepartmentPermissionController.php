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
        $permissions = DepartmentPermission::with('department')
            ->orderBy('department_id')->orderBy('resource')
            ->paginate(20);

        $departments = Department::orderBy('name')->get(['id','name']);

        // Keep your view name if you like; just be consistent with what you created
        return view('permissions.index', compact('permissions', 'departments'));
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

        // ✅ use your new route name
        return redirect()->route('departments.permissions.index')->with('ok', 'Permission saved.');
    }

    public function edit(Department $department)
    {
        // customize your resource list here (or pull from config)
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

        // ✅ this view must use $department / $resources / $matrix (no $dept_permission)
        return view('permissions.edit', compact('department','resources','matrix'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'permissions' => ['array'], // permissions[resource][flag] = 1
        ]);

        $perms = $data['permissions'] ?? [];
        $resources = ['project','invoice','customer']; // same list as in edit()

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
        // ✅ use new route name
        return redirect()->route('departments.permissions.index')->with('ok', 'Permission deleted.');
    }
}
