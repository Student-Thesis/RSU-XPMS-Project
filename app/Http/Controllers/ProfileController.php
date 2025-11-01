<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profiles.index');
    }

    public function edit(Request $request)
    {
        $user = $request->user();
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

        // keep snapshot before
        $before = $user->toArray();
        $avatarChanged = false;

        // Debug log to see if file arrived
        Log::info('Profile update request', [
            'user_id'   => $user->id,
            'has_file'  => $request->hasFile('avatar'),
            'file_valid'=> $request->file('avatar')?->isValid(),
            'mime'      => $request->file('avatar')?->getMimeType(),
            'size'      => $request->file('avatar')?->getSize(),
        ]);

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $dir = public_path('avatars');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }

            $ext  = $request->file('avatar')->extension();
            $name = Str::slug($user->name ?: 'user') . '-' . Str::random(8) . '.' . $ext;

            // Move uploaded file to public/avatars
            $request->file('avatar')->move($dir, $name);

            // Delete old avatar if exists
            if ($user->avatar_path && file_exists(public_path($user->avatar_path))) {
                @unlink(public_path($user->avatar_path));
            }

            $user->avatar_path = 'avatars/' . $name;
            $avatarChanged = true;
        }

        // update basic fields
        $user->first_name = $validated['first_name'] ?? $user->first_name;
        $user->last_name  = $validated['last_name']  ?? $user->last_name;
        $user->username   = $validated['username']   ?? $user->username;
        $user->phone      = $validated['phone']      ?? $user->phone;
        $user->college    = $validated['college']    ?? $user->college;
        $user->about      = $validated['about']      ?? $user->about;
        $user->save();

        // snapshot after
        $after = $user->fresh()->toArray();

        // 🔐 log profile update
        $this->logActivity('Updated Profile', [
            'before'         => $before,
            'after'          => $after,
            'avatar_changed' => $avatarChanged,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Local logging helper (no trait)
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id'          => (string) Str::uuid(),
            'user_id'     => Auth::id(),
            'action'      => $action,
            'model_type'  => 'profile',        // not tied to a model, just label it
            'model_id'    => Auth::id(),       // or null if you want
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
