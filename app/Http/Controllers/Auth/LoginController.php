<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Default redirect after login if there's no intended URL.
     */
    protected string $redirectTo = '/dashboard';

    public function __construct()
    {
        // Guests can access login; only authenticated users can hit logout.
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the login form (optional override).
     * If you use the default from laravel/ui, you can remove this.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    /**
     * We accept a single "login" field which can be either email or username.
     * The base trait calls $this->username() for the field name to validate.
     */
    public function username(): string
    {
        return 'login'; // <input name="login">
    }

    /**
     * Validate the login request. We customize to accept email OR username.
     */
    protected function validateLogin(Request $request): void
    {
        $request->validate([
            'login'    => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);
    }

    /**
     * Build the credentials array for the attempt().
     * Detect whether "login" is an email or a username.
     * Optionally enforce is_active = 1 if your users table has it.
     */
    protected function credentials(Request $request): array
    {
        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $creds = [
            $field    => $login,
            'password'=> $request->input('password'),
        ];

        // If you have an 'is_active' column and want to block inactive accounts:
        // $creds['is_active'] = 1;

        return $creds;
    }

    /**
     * Attempt to log the user in (kept for clarity so we can handle "remember").
     * AuthenticatesUsers::attemptLogin already does this, but we inject remember.
     */
    protected function attemptLogin(Request $request): bool
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->boolean('remember') // <input type="checkbox" name="remember">
        );
    }

    /**
     * Where to send users after login.
     * Uses intended() when available, then falls back to $redirectTo.
     */
    protected function redirectTo(): string
    {
        return url()->previous() === route('login')
            ? $this->redirectTo
            : $this->redirectPath();
    }

    /**
     * Hook after successful authentication.
     * Return a response to override the default redirect.
     */
    protected function authenticated(Request $request, $user)
    {
        // Example: force email verification before proceeding
        // if (method_exists($user, 'hasVerifiedEmail') && ! $user->hasVerifiedEmail()) {
        //     auth()->logout();
        //     throw ValidationException::withMessages([
        //         'login' => 'Please verify your email address before logging in.',
        //     ]);
        // }

        // Default: do nothing → continue normal redirect.
    }

    /**
     * Hook after logout—send them to login page.
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }

    /**
     * If you want custom error messaging for invalid login:
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')], // "These credentials do not match our records."
        ]);
    }
}
