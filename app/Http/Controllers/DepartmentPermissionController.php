<?php
// app/Http/Controllers/DepartmentPermissionController.php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Permission;
use Illuminate\Http\Request;

class DepartmentPermissionController extends Controller
{
    public function edit(Department $department)
    {
        // All available permissions
        $permissions = Permission::orderBy('slug')->get(['id','name','slug']);

        // Current permission IDs for the department (for checkbox default state)
        $current = $department->permissions()->pluck('permissions.id')->all();

        return view('settings.permissions.index', [
            'department'  => $department,
            'permissions' => $permissions,
            'current'     => $current,
        ]);
    }

    public function update(Request $request, Department $department)
    {
        // Validate: we accept an array of UUIDs (permission IDs) or empty (none checked)
        $data = $request->validate([
            'permissions'   => ['nullable','array'],
            'permissions.*' => ['uuid','exists:permissions,id'],
        ]);

        // Sync pivot
        $department->permissions()->sync($data['permissions'] ?? []);

        return redirect()
            ->route('departments.permissions.edit', $department)
            ->with('ok', 'Permissions updated for department: '.$department->name);
    }
}
