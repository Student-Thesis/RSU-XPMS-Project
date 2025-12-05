<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentPermission;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DepartmentPermissionController extends Controller
{
    public function index()
    {
        // ✅ Only departments that have at least one permission
        $departments = Department::withCount('permissions') 
            ->whereHas('permissions')
            ->orderBy('name')
            ->paginate(20);

        $resources = ['project','forms','faculty','users','calendar'];

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

        $perm = DepartmentPermission::updateOrCreate(
            ['department_id' => $data['department_id'], 'resource' => $data['resource']],
            $data
        );

        // 🔐 log create/update
        $this->logActivity('Saved Department Permission', [
            'permission' => $perm->toArray(),
        ]);

        return redirect()->route('departments.permissions.index')->with('ok', 'Permission saved.');
    }

  public function show(Department $department)
{
    $resources = ['project','forms','faculty','users','calendar'];

    $existing = DepartmentPermission::where('department_id', $department->id)
        ->get()
        ->keyBy('resource');

    $matrix = collect($resources)->mapWithKeys(function ($res) use ($existing) {
        $row = $existing->get($res);
        return [
            $res => [
                'can_view'   => (bool) optional($row)->can_view,
                'can_create' => (bool) optional($row)->can_create,
                'can_update' => (bool) optional($row)->can_update,
                'can_delete' => (bool) optional($row)->can_delete,
            ]
        ];
    });

    // Users under this department OR same role
    $users = \App\Models\User::where('department_id', $department->id)
        ->orWhere('user_type', $department->name)
        ->orderBy('first_name')
        ->get();

    return view('permissions.show', compact('department','resources','matrix','users'));
}


    public function edit(Department $department)
    {
        $resources = ['project','forms','faculty','users','calendar'];

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
            'permissions' => ['array'],
        ]);

        $permsInput = $data['permissions'] ?? [];

        // you had different lists in index/edit/update — I'll unify it here,
        // but you can change to match your actual resources
        $resources = ['project','forms','faculty','users','calendar'];

        // take snapshot before
        $before = DepartmentPermission::where('department_id', $department->id)->get()->toArray();

        DB::transaction(function () use ($department, $permsInput, $resources) {
            foreach ($resources as $res) {
                $row = $permsInput[$res] ?? [];

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

        // snapshot after
        $after = DepartmentPermission::where('department_id', $department->id)->get()->toArray();

        // 🔐 log update
        $this->logActivity('Updated Department Permissions', [
            'department_id' => $department->id,
            'before' => $before,
            'after'  => $after,
        ]);

        return redirect()
            ->route('departments.permissions.edit', $department)
            ->with('ok', 'Permissions updated.');
    }

    public function destroy(DepartmentPermission $dept_permission)
    {
        $data = $dept_permission->toArray();
        $dept_permission->delete();

        // 🔐 log delete
        $this->logActivity('Deleted Department Permission', [
            'permission' => $data,
        ]);

        return redirect()->route('departments.permissions.index')->with('ok', 'Permission deleted.');
    }

    /**
     * Local logging helper
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id'          => Str::uuid(),
            'user_id'     => Auth::id(),
            'notifiable_user_id' => Auth::id(),
            'action'      => $action,
            'model_type'  => DepartmentPermission::class,
            'model_id'    => $changes['permission']['id'] ?? null,
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }

    public function editUser(\App\Models\User $user)
{
    // Same list of resources
    $resources = ['project','forms','faculty','users','calendar'];

    // Load user-level permissions (if you store them in UserPermission model)
    $existing = \App\Models\UserPermission::where('user_id', $user->id)
        ->get()
        ->keyBy('resource');

    $matrix = collect($resources)->mapWithKeys(function ($res) use ($existing) {
        $row = $existing->get($res);
        return [
            $res => [
                'can_view'   => (bool) optional($row)->can_view,
                'can_create' => (bool) optional($row)->can_create,
                'can_update' => (bool) optional($row)->can_update,
                'can_delete' => (bool) optional($row)->can_delete,
            ]
        ];
    });

    return view('permissions.user_edit', compact('user','resources','matrix'));
}

public function updateUser(Request $request, \App\Models\User $user)
{
    $data = $request->validate([
        'permissions' => ['array']
    ]);

    $resources = ['project','forms','faculty','users','calendar'];
    $perms = $data['permissions'] ?? [];

    // Before snapshot
    $before = \App\Models\UserPermission::where('user_id', $user->id)->get()->toArray();

    DB::transaction(function () use ($user, $resources, $perms) {
        foreach ($resources as $res) {
            $row = $perms[$res] ?? [];

            $flags = [
                'can_view'   => (bool)($row['can_view'] ?? false),
                'can_create' => (bool)($row['can_create'] ?? false),
                'can_update' => (bool)($row['can_update'] ?? false),
                'can_delete' => (bool)($row['can_delete'] ?? false),
            ];

            // If no permission → remove row
            if (!array_filter($flags)) {
                \App\Models\UserPermission::where('user_id', $user->id)
                    ->where('resource', $res)
                    ->delete();
                continue;
            }

            \App\Models\UserPermission::updateOrCreate(
                ['user_id' => $user->id, 'resource' => $res],
                $flags
            );
        }
    });

    // After snapshot
    $after = \App\Models\UserPermission::where('user_id', $user->id)->get()->toArray();

    $this->logActivity('Updated User Permissions', [
        'user_id' => $user->id,
        'before' => $before,
        'after'  => $after,
    ]);

    return redirect()
        ->route('departments.permissions.user.edit', $user->id)
        ->with('ok', 'User permissions updated.');
}


}
