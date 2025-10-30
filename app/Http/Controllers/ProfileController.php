<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profiles.index');
    }

    public function edit(Request $request)
    {
        $user = $request->user();

        // Reuse your existing profile view or a dedicated edit view
        // If you want to reuse the view you pasted, pass $user and render inputs.
        return view('profiles.edit', compact('user'));
    }
    public function update(Request $request)
    {
        $user = $request->user();

    $validated = $request->validate([
        'first_name' => ['nullable', 'string', 'max:255'],
        'last_name'  => ['nullable', 'string', 'max:255'],
        'username'   => ['nullable', 'string', 'max:150'],
        'phone'      => ['nullable', 'string', 'max:30'],
        'college'    => ['nullable', 'string', 'max:255'],
        'about'      => ['nullable', 'string', 'max:2000'],
        'avatar'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
    ]);

        // Debug log to see if file arrived
        Log::info('Profile update request', [
            'has_file' => $request->hasFile('avatar'),
            'file_valid' => $request->file('avatar')?->isValid(),
            'mime' => $request->file('avatar')?->getMimeType(),
            'size' => $request->file('avatar')?->getSize(),
        ]);

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // Ensure public/avatars exists
            $dir = public_path('avatars');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }

            // Generate clean unique filename
            $ext = $request->file('avatar')->extension();
            $name = Str::slug($user->name ?: 'user') . '-' . Str::random(8) . '.' . $ext;

            // Move uploaded file to public/avatars
            $request->file('avatar')->move($dir, $name);

            // Delete old avatar if exists
            if ($user->avatar_path && file_exists(public_path($user->avatar_path))) {
                unlink(public_path($user->avatar_path));
            }

            // Save relative path (for easy use in Blade)
            $user->avatar_path = 'avatars/' . $name;
        }

        $user->first_name = $validated['first_name'] ?? $user->first_name;
    $user->last_name  = $validated['last_name'] ?? $user->last_name;
    $user->username   = $validated['username'] ?? $user->username;
    $user->phone      = $validated['phone'] ?? $user->phone;
    $user->college    = $validated['college'] ?? $user->college;
    $user->about      = $validated['about'] ?? $user->about;
    $user->save();

    return back()->with('success', 'Profile updated successfully.');
    }
}
