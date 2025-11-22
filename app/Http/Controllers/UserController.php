<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
   public function index(Request $request)
{
    $q    = $request->get('q');
    $role = $request->get('role', 'All'); // currently selected role (string)

    // Options for the dropdown
    $roles = [
        'All'         => 'All Roles',
        'admin'       => 'Admin',
        'user'        => 'User',
        'coordinator' => 'Coordinator',
        'manager'     => 'Manager',
    ];

    $query = User::query();

    // 🔍 CASE-SENSITIVE SEARCH
    if ($q) {
        $query->where(function ($w) use ($q) {
            $w->whereRaw('BINARY first_name LIKE ?', ["%{$q}%"])
                ->orWhereRaw('BINARY last_name LIKE ?', ["%{$q}%"])
                ->orWhereRaw('BINARY email LIKE ?', ["%{$q}%"])
                ->orWhereRaw('BINARY phone LIKE ?', ["%{$q}%"]);
        });
    }

    // 🎭 Role Filter
    if ($role && $role !== 'All') {
        $query->where('user_type', $role);
    }

    $users = $query->paginate(20)->withQueryString();

    // pass BOTH $roles (array) and $role (selected)
    return view('users.index', compact('users', 'q', 'roles', 'role'));
}


    public function create()
    {
        $roles = ['admin', 'user', 'coordinator', 'manager'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_type' => ['required', Rule::in(['admin', 'user', 'coordinator', 'manager'])],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:30'],
            'about' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Save avatar directly to /public/avatars
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'about' => ['nullable', 'string'],
            'department_id' => ['required', 'integer', Rule::in([2, 3, 4])],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'avatar' => ['nullable', 'image'],
            'status' => ['nullable', 'string'],
        ]);

        // map dept -> user_type (keep DB consistent)
        $deptToType = [
            2 => 'Manager',
            3 => 'Coordinator',
            4 => 'User',
        ];
        $validated['user_type'] = $deptToType[$validated['department_id']] ?? 'User';

        // snapshot before
        $beforeStatus = $user->status;

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

            $file = $request->file('avatar');
            $filename = uniqid('avatar_') . '.' . $file->getClientOriginalExtension();

            if (!is_dir(public_path('avatars'))) {
                mkdir(public_path('avatars'), 0755, true);
            }

            $file->move(public_path('avatars'), $filename);
            $validated['avatar_path'] = 'avatars/' . $filename;
        }

        $user->update($validated);

        // snapshot after
        $user->refresh();
        $after = $user->toArray();
        $afterStatus = $user->status;

        // 🔐 log update
        $this->logActivity('Updated User', [
            'target_user_id' => $user->id,
            'before' => $beforeStatus,
            'after' => $afterStatus,
        ]);

        // ✅ If status has just changed to Approved → send email
        if ($afterStatus === 'Approved' && $beforeStatus !== 'Approved') {
            try {
                Mail::raw("Hi {$user->first_name},\n\n" . "Your account has been approved. You can now log in and start using the system.\n\n" . "If you did not request this account, please contact the administrator.\n\n" . 'Thank you.', function ($message) use ($user) {
                    $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Your Account Has Been Approved');
                });
            } catch (\Throwable $mailException) {
                \Log::warning('User approved but approval email failed to send', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $mailException->getMessage(),
                ]);
            }
        }

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
            'id' => (string) Str::uuid(),
            'user_id' => Auth::id(),
            'notifiable_user_id' => Auth::id(), // who did the action
            'action' => $action,
            'model_type' => User::class, // what model type
            'model_id' => $changes['target_user']['id'] ?? ($changes['target_user_id'] ?? null), // which user was affected
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
