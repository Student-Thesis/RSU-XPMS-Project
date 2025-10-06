<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Default redirect if no custom logic in registered().
     *
     * @var string
     */
    protected $redirectTo = '/proposals';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Log::info('Validating registration data', ['data' => $data]);

        return Validator::make($data, [
            'username'       => ['required', 'string', 'max:50', 'unique:users'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'college'    => ['required', 'string', 'max:100'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            $user = User::create([
                'username'       => $data['username'],
                'first_name' => $data['first_name'] ?? '',
                'last_name'  => $data['last_name'] ?? '',
                'college'    => $data['college'],
                'email'      => $data['email'],
                'password'   => Hash::make($data['password']),
                'user_type'  => 'user', // default role
            ]);

            Log::info('User registered successfully', ['id' => $user->id, 'email' => $user->email]);

            return $user;
        } catch (\Exception $e) {
            Log::error('User registration failed', [
                'error' => $e->getMessage(),
                'data'  => $data
            ]);
            throw $e;
        }
    }

    /**
     * Redirect users after successful registration.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function registered(Request $request, $user)
    {
        if ($user) {
            Log::info('Redirecting after registration', ['user_id' => $user->id]);
            return redirect('/proposals');
        }

        Log::warning('Registration complete but no user instance found.');
        return redirect('/register'); // fallback
    }
}
