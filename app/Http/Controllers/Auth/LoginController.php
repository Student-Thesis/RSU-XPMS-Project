<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * ✅ Override login validation
     * Replaces image captcha with Cloudflare Turnstile
     */
    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'string'],
                'password' => ['required', 'string'],
                'cf-turnstile-response' => ['required'],
            ],
            [
                'cf-turnstile-response.required' => 'Please confirm you are human.',
            ]
        );

        // ✅ Verify Turnstile server-side
        $resp = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (!($resp->json('success') ?? false)) {
            // attach to "captcha" error key for easy display
            abort(
                redirect()->back()
                    ->withErrors(['captcha' => 'Security verification failed. Please try again.'])
                    ->withInput()
            );
        }
    }

    /**
     * After user is authenticated...
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->status !== 'Approved') {
            auth()->logout();

            return redirect()
                ->route('login')
                ->with('error', 'Your account is not yet approved.');
        }
    }
}
