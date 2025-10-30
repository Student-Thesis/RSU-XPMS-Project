<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\DeptGate;

class DepartmentPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Use it like: ->middleware('dept.can:project,view')
     */
    public function handle(Request $request, Closure $next, string $resource, string $action)
    {
        $user = $request->user();

        if (!DeptGate::can($user, $resource, $action)) {
            // you can redirect instead:
            // return redirect()->route('dashboard')->with('error','Not allowed.');
            abort(403, 'You are not allowed to access this feature.');
        }

        return $next($request);
    }
}
