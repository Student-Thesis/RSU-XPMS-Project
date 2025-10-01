<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

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
                      ->orWhere('last_name',  'like', "%{$q}%")
                      ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$q}%"])
                      ->orWhere('email',      'like', "%{$q}%")
                      ->orWhere('phone',      'like', "%{$q}%");
                });
            })
            ->when($role && $role !== 'all', fn($qr) => $qr->where('user_type', $role))
            ->where('user_type', '!=', 'root') // exclude root user
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $roles = [
            'all'             => 'All Roles',
            'admin'           => 'Admin',
            'user'            => 'User',
            'coordinator'          => 'Coordinator',
            'manager' => 'Project Manager',
        ];

        return view('users.index', compact('users','q','role','roles'));
    }

    public function create()
    {
        $roles = ['admin','user','coordinator','manager'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validate with split names
        $validated = $request->validate([
             'user_type'  => ['required', Rule::in(['admin','user','coordinator','manager'])],
            'first_name' => ['required','string','max:255'],
            'last_name'  => ['required','string','max:255'],
            'email'      => ['required','email:rfc,dns','unique:users,email'],
            'password'   => ['required','string','min:8','confirmed'],
            'phone'      => ['nullable','string','max:30'],
            'about'      => ['nullable','string'],
            'avatar'     => ['nullable','image'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Save avatar directly to /public/avatars
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = uniqid('avatar_').'.'.$file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $filename);
            $validated['avatar_path'] = 'avatars/'.$filename;
        }

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
       $roles = ['admin','user','coordinator','manager'];
        return view('users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'user_type'  => ['required', Rule::in(['admin','user','coordinator','manager'])],
            'first_name' => ['required','string','max:255'],
            'last_name'  => ['required','string','max:255'],
            'email'      => ['required','email:rfc,dns', Rule::unique('users','email')->ignore($user->id)],
            'phone'      => ['nullable','string','max:30'],
            'about'      => ['nullable','string'],
            'avatar'     => ['nullable','image'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path && file_exists(public_path($user->avatar_path))) {
                @unlink(public_path($user->avatar_path));
            }
            $file = $request->file('avatar');
            $filename = uniqid('avatar_').'.'.$file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $filename);
            $validated['avatar_path'] = 'avatars/'.$filename;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if ($user->avatar_path && file_exists(public_path($user->avatar_path))) {
            @unlink(public_path($user->avatar_path));
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}
