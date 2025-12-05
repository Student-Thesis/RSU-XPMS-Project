<?php

namespace App\Support;

use App\Models\DepartmentPermission;
use App\Models\UserPermission;

class DeptGate
{
    public static function can($user, string $resource, string $action): bool
    {
        if (!$user) {
            return false;
        }

        // map action -> column
        $col = match ($action) {
            'view'   => 'can_view',
            'create' => 'can_create',
            'update' => 'can_update',
            'delete' => 'can_delete',
            default  => null,
        };

        if (!$col) {
            return false;
        }

        // 1️⃣ Check explicit user-level permission first
        $userPerm = UserPermission::where('user_id', $user->id)
            ->where('resource', $resource)
            ->first();

        if ($userPerm) {
            return (bool) $userPerm->{$col};
        }

        // 2️⃣ Fallback: department-level permission
        if (!$user->department_id) {
            return false;
        }

        $deptPerm = DepartmentPermission::where('department_id', $user->department_id)
            ->where('resource', $resource)
            ->first();

        if (!$deptPerm) {
            return false;
        }

        return (bool) $deptPerm->{$col};
    }
}
