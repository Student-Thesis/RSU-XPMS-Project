<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/proposals';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        Log::info('Validating registration data', ['data' => $data]);

        return Validator::make($data, [
            'username'  => ['required', 'string', 'max:50', 'unique:users'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'college'   => ['required', 'string', 'max:100'],
        ]);
    }

    protected function create(array $data)
    {
        try {
            $user = User::create([
                'username'   => $data['username'],
                'first_name' => $data['first_name'] ?? '',
                'last_name'  => $data['last_name'] ?? '',
                'college'    => $data['college'],
                'email'      => $data['email'],
                'password'   => Hash::make($data['password']),
                'user_type'  => 'user',
            ]);

            Log::info('User registered successfully', ['id' => $user->id, 'email' => $user->email]);
            return $user;
        } catch (\Exception $e) {
            Log::error('User registration failed', ['error' => $e->getMessage(), 'data' => $data]);
            throw $e;
        }
    }

    protected function registered(Request $request, $user)
    {
        // Manually log in the new user (if not already)
        Auth::login($user);

        Log::info('Redirecting after registration', ['user_id' => $user->id]);

        // Optionally, pass data to /proposals
        return redirect()->route('proposals.index')->with([
            'success' => 'Welcome, ' . $user->first_name . '!',
            'user'    => $user->only(['id', 'username', 'email', 'college']),
        ]);
    }
}
