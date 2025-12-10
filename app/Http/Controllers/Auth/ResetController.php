<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResetController extends Controller
{
    // -----------------------------------------
    // 1. Show Email Form
    // -----------------------------------------
    public function showEmailForm()
    {
        return view('auth.reset');
    }

    // -----------------------------------------
    // 2. Send 6-digit Code to Gmail
    // -----------------------------------------
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found.']);
        }

        // Generate 6-digit code
        $code = rand(100000, 999999);

        // Store code
        DB::table('password_reset_codes')->updateOrInsert(
            ['email' => $request->email],
            [
                'code'       => $code,
                'used_at'    => null,
                'expires_at' => now()->addMinutes(10),
                'created_at' => now()
            ]
        );

        // Send Email via Gmail
        Mail::raw("Your password reset code is: $code \nThis code expires in 10 minutes.", function ($m) use ($request) {
            $m->to($request->email)->subject('Your Password Reset Code');
        });

        return redirect()->route('password.verify.custom')
            ->with('email', $request->email);
    }

    // -----------------------------------------
    // 3. Show Verify Code + New Password Form
    // -----------------------------------------
    public function showVerifyForm(Request $request)
    {
        $email = session('email');
        if (!$email) return redirect()->route('password.request');

        return view('auth.password-verify', compact('email'));
    }

    // -----------------------------------------
    // 4. Reset Password
    // -----------------------------------------
    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email'                 => 'required|email',
            'code'                  => 'required|string|size:6',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_codes')
            ->where('email', $data['email'])
            ->where('code', $data['code'])
            ->whereNull('used_at')
            ->where('expires_at', '>=', now())
            ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Invalid or expired code.']);
        }

        $user = User::where('email', $data['email'])->first();
        $user->password = Hash::make($data['password']);
        $user->save();

        DB::table('password_reset_codes')
            ->where('email', $data['email'])
            ->update(['used_at' => now()]);

        return view('auth.login')->with('success', 'Password reset successfully.');
    }
}
