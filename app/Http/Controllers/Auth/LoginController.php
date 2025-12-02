<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * Only guests can access login, except logout.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override the default login validation
     * to include image CAPTCHA (mews/captcha).
     */
    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                $this->username() => ['required', 'string'], // usually "email"
                'password'        => ['required', 'string'],
                'captcha'         => ['required', 'captcha'],
            ],
            [
                'captcha.required' => 'Please enter the security code shown in the image.',
                'captcha.captcha'  => 'Invalid security code. Please try again.',
            ]
        );
    }

    /**
     * After user is authenticated...
     */
    protected function authenticated(Request $request, $user)
    {
        // Check if user status is not Approved
        if ($user->status !== 'Approved') {

            auth()->logout(); // logout immediately

            return redirect()
                ->route('login')
                ->with('error', 'Your account is not yet approved.');
        }
    }
}
