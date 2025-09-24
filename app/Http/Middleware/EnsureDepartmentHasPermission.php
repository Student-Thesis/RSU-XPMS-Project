<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class EnsureDepartmentHasPermission
{
    public function handle(Request $request, Closure $next, string $requiredSlug): Response
    {
        $user = $request->user();

        if (!$user) {
            return $this->deny($request, 'Unauthenticated.');
        }

        if ($user->isRoot()) {
            return $next($request);
        }

        if (!$user->department) {
            return $this->deny($request, 'No department assigned.');
        }

        $dept = $user->department;

        $cacheKey = "dept_perms:{$dept->getKey()}";
        $slugs = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($dept) {
            return $dept->permissions()->pluck('slug')->map(fn ($s) => (string) $s)->all();
        });

        if (!in_array($requiredSlug, $slugs, true)) {
            return $this->deny($request, "Missing permission '{$requiredSlug}'.");
        }

        return $next($request);
    }

    protected function deny(Request $request, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden', 'reason' => $message], 403);
        }
        abort(403, $message);
    }
}
