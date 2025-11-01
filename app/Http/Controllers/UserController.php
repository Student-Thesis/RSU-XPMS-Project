<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q    = trim($request->get('q', ''));
        $role = $request->get('role', '');

        $users = User::query()
            ->when($q, function ($qr) use ($q) {
                $qr->where(function ($w) use ($q) {
                    $w->where('first_name', 'like', "%{$q}%")
                        ->orWhere('last_name', 'like', "%{$q}%")
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$q}%"])
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%");
                });
            })
            ->when($role && $role !== 'all', fn($qr) => $qr->where('user_type', $role))
            ->where('user_type', '!=', 'root') // exclude root user
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $roles = [
            'all'        => 'All Roles',
            'admin'      => 'Admin',
            'user'       => 'User',
            'coordinator'=> 'Coordinator',
            'manager'    => 'Project Manager',
        ];

        return view('users.index', compact('users', 'q', 'role', 'roles'));
    }

    public function create()
    {
        $roles = ['admin', 'user', 'coordinator', 'manager'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_type'  => ['required', Rule::in(['admin', 'user', 'coordinator', 'manager'])],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email:rfc,dns', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'about'      => ['nullable', 'string'],
            'avatar'     => ['nullable', 'image'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Save avatar directly to /public/avatars
        if ($request->hasFile('avatar')) {
            $file     = $request->file('avatar');
            $filename = uniqid('avatar_') . '.' . $file->getClientOriginalExtension();

            if (!is_dir(public_path('avatars'))) {
                mkdir(public_path('avatars'), 0755, true);
            }

            $file->move(public_path('avatars'), $filename);
            $validated['avatar_path'] = 'avatars/' . $filename;
        }

        $user = User::create($validated);

        // 🔐 log create
        $this->logActivity('Created User', [
            'target_user' => $user->toArray(),
        ]);

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        // static departments (exclude Admin = 1)
        $departments = [
            2 => 'Manager',
            3 => 'Coordinator',
            4 => 'User',
        ];

        return view('users.edit', compact('user', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email:rfc,dns', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'         => ['nullable', 'string', 'max:30'],
            'about'         => ['nullable', 'string'],
            'department_id' => ['required', 'integer', Rule::in([2, 3, 4])],
            'password'      => ['nullable', 'confirmed', 'min:8'],
            'avatar'        => ['nullable', 'image'],
        ]);

        // map dept -> user_type (keep DB consistent)
        $deptToType = [
            2 => 'Manager',
            3 => 'Coordinator',
            4 => 'User',
        ];
        $validated['user_type'] = $deptToType[$validated['department_id']] ?? 'User';

        // keep snapshot before
        $before = $user->toArray();

        // handle password (optional)
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // handle avatar (optional)
        if ($request->hasFile('avatar')) {
            if ($user->avatar_path && file_exists(public_path($user->avatar_path))) {
                @unlink(public_path($user->avatar_path));
            }

            $file     = $request->file('avatar');
            $filename = uniqid('avatar_') . '.' . $file->getClientOriginalExtension();

            if (!is_dir(public_path('avatars'))) {
                mkdir(public_path('avatars'), 0755, true);
            }

            $file->move(public_path('avatars'), $filename);
            $validated['avatar_path'] = 'avatars/' . $filename;
        }

        $user->update($validated);

        // snapshot after
        $after = $user->fresh()->toArray();

        // 🔐 log update
        $this->logActivity('Updated User', [
            'target_user_id' => $user->id,
            'before'         => $before,
            'after'          => $after,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $dump = $user->toArray();

        if ($user->avatar_path && file_exists(public_path($user->avatar_path))) {
            @unlink(public_path($user->avatar_path));
        }

        $user->delete();

        // 🔐 log delete
        $this->logActivity('Deleted User', [
            'target_user' => $dump,
        ]);

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    /**
     * Local activity logger (no trait)
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id'          => (string) Str::uuid(),
            'user_id'     => Auth::id(),         // who did the action
            'action'      => $action,
            'model_type'  => User::class,        // what model type
            'model_id'    => $changes['target_user']['id']
                             ?? $changes['target_user_id']
                             ?? null,           // which user was affected
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
