<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use App\Models\User;

class DeptCan
{
    public static function check(?User $user, string $slug): bool
    {
        if (!$user) return false;
        if ($user->isRoot()) return true;
        if (!$user->department) return false;

        $key = "dept_perms:{$user->department->getKey()}";
        $slugs = Cache::remember($key, now()->addMinutes(5), function () use ($user) {
            return $user->department->permissions()->pluck('slug')->all();
        });

        return in_array($slug, $slugs, true);
    }
}
