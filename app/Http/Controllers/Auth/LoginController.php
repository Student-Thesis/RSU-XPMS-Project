<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
     * ✅ VALIDATE LOGIN + TURNSTILE
     */
    protected function validateLogin(Request $request)
    {
        /**
         * 1️⃣ Basic field validation
         */
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
            'cf-turnstile-response' => ['required'],
        ], [
            'cf-turnstile-response.required' => 'Please confirm you are human.',
        ]);

        /**
         * 2️⃣ Verify Cloudflare Turnstile
         */
        $resp = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret'   => config('services.turnstile.secret_key'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]
        );

        $data = $resp->json();

        /**
         * 3️⃣ TEMP DEBUG LOG (check storage/logs/laravel.log)
         */
        Log::info('Turnstile verify', [
            'success'     => $data['success'] ?? null,
            'error_codes' => $data['error-codes'] ?? null,
            'hostname'    => $data['hostname'] ?? null,
        ]);

        /**
         * 4️⃣ If Turnstile fails → validation error
         */
        if (!($data['success'] ?? false)) {
            Validator::make([], [
                'captcha' => ['required'],
            ], [
                'captcha.required' =>
                    'Security verification failed (' .
                    implode(',', $data['error-codes'] ?? ['unknown']) .
                    ').',
            ])->validate();
        }
    }

    /**
     * ✅ AFTER LOGIN CHECK
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
