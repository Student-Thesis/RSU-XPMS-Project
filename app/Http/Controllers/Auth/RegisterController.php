<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $redirectTo = '/proposals';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Custom register method
     * - Creates user
     * - Does NOT log them in
     * - Redirects to proposals.create
     * - Passes registered_user_id via session
     */
    public function register(Request $request)
    {
        Log::info('Validating registration data', ['data' => $request->all()]);

        $this->validator($request->all())->validate();

        // Create user
        $user = $this->create($request->all());

        Log::info('User registered (no login)', [
            'id'         => $user->id,
            'email'      => $user->email,
            'dept'       => $user->department_id,
            'user_type'  => $user->user_type,
        ]);

        // Redirect to proposals.create and pass registered_user_id
        return redirect()
            ->route('proposals.index')
            ->with('registered_user_id', $user->id)
            ->with('success', 'Your account has been created. You may now proceed to submit proposals.');
    }

    /**
     * Validator for registration input.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'username'      => ['required', 'string', 'max:50', 'unique:users,username'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'         => ['nullable', 'string', 'max:30'],
            'college'       => ['required', 'string', 'max:100'],
            // only allow Manager(2), Coordinator(3), User(4)
            'department_id' => ['required', 'integer', 'in:2,3,4'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Actually create the user record.
     */
    protected function create(array $data)
    {
        // map department -> user_type
        $deptToType = [
            2 => 'Manager',
            3 => 'Coordinator',
            4 => 'User',
        ];

        $userType = $deptToType[$data['department_id']] ?? 'user';

        try {
            $user = User::create([
                'first_name'    => $data['first_name'],
                'last_name'     => $data['last_name'],
                'username'      => $data['username'],
                'email'         => $data['email'],
                'phone'         => $data['phone'] ?? null,
                'college'       => $data['college'],
                'department_id' => $data['department_id'],
                'user_type'     => $userType,
                'password'      => Hash::make($data['password']),
            ]);

            Log::info('User created successfully', [
                'id'        => $user->id,
                'email'     => $user->email,
                'user_type' => $user->user_type,
            ]);

            return $user;

        } catch (\Exception $e) {
            Log::error('User creation failed', [
                'error' => $e->getMessage(),
                'data'  => $data,
            ]);
            throw $e;
        }
    }
}
