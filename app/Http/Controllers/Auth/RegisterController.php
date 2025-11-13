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
use Illuminate\Support\Facades\Mail;

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
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'college' => ['required', 'string', 'max:100'],
            // only allow Manager(2), Coordinator(3), User(4)
            'department_id' => ['required', 'integer', 'in:2,3,4'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

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
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'college' => $data['college'],
                'department_id' => $data['department_id'],
                'user_type' => $userType,
                'password' => Hash::make($data['password']),
            ]);

            Log::info('User registered successfully', [
                'id' => $user->id,
                'email' => $user->email,
                'dept' => $user->department_id,
                'user_type' => $user->user_type,
            ]);

            // ============================
            // Send Welcome Email via Gmail
            // ============================
            try {
                Mail::raw("Hi {$user->first_name},\n\n" . "Your account has been created successfully.\n\n" . "Username: {$user->username}\n" . "Email: {$user->email}\n\n" . "You can now log in to the system.\n\n" . 'Thank you.', function ($message) use ($user) {
                    $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Your Account Has Been Created');
                });
            } catch (\Throwable $mailException) {
                // Don’t block registration if email fails
                Log::warning('User registered but welcome email failed to send', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $mailException->getMessage(),
                ]);
            }

            return $user;
        } catch (\Exception $e) {
            Log::error('User registration failed', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            throw $e;
        }
    }

    protected function registered(Request $request, $user)
    {
        // In case RegistersUsers didn't do it yet
        Auth::login($user);

        Log::info('Redirecting after registration', ['user_id' => $user->id]);

        return redirect()
            ->route('proposals.index')
            ->with([
                'success' => 'Welcome, ' . ($user->first_name ?: $user->username) . '!',
                'user' => $user->only(['id', 'username', 'email', 'college', 'department_id', 'user_type']),
            ]);
    }
}
