<?php

namespace App\Support;

use App\Models\DepartmentPermission;

class DeptGate
{
    /**
     * Check if the given user can perform $action on $resource
     * e.g. can($user, 'project', 'view')
     */
    public static function can($user, string $resource, string $action): bool
    {
        // user has no department -> deny
        if (!$user || !$user->department_id) {
            return false;
        }

        $perm = DepartmentPermission::where('department_id', $user->department_id)
            ->where('resource', $resource)
            ->first();

        if (!$perm) {
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

        return (bool) $perm->{$col};
    }
}
