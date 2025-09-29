<?php

// app/Http/Middleware/CheckDeptPerm.php
namespace App\Http\Middleware;

use App\Models\DepartmentPermission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDeptPerm
{
    public function handle(Request $request, Closure $next, string $resource, string $action): Response
    {
        $user = $request->user();
        if (!$user) {
            abort(401, 'Unauthenticated');
        }

        // ✅ Root user bypasses all checks
        if ($user->user_type === 'root') {
            return $next($request);
        }
 
        $deptId = $user->department_id;
        if (!$deptId) {
            abort(403, 'No department assigned.');
        }

        $perm = \App\Models\DepartmentPermission::where('department_id', $deptId)->where('resource', $resource)->first();

        $map = [
            'view' => 'can_view',
            'create' => 'can_create',
            'update' => 'can_update',
            'delete' => 'can_delete',
        ];

        $column = $map[$action] ?? null;

        if (!$column || !$perm || !$perm->{$column}) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
