<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * After user is authenticated...
     */
    protected function authenticated($request, $user)
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
