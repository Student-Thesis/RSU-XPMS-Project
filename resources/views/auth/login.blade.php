<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>RSU - XPMS</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Custom Gradient Styling Inspired by Logo -->
    <style>
        body {
            background: linear-gradient(135deg, #f44336, #2196f3, #4caf50, #ffeb3b);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .card {
            background-color: #ffffffcc;
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }

        .auth-btn {
            background: linear-gradient(to right, #f44336, #2196f3, #4caf50, #ffeb3b);
            background-size: 200%;
            color: #fff;
            border: none;
            transition: background-position 0.3s ease;
        }

        .auth-btn:hover {
            background-position: right center;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
        }

        .form-check-label {
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card p-4">
                    <div class="text-center mb-4">
                        <img src="/images/logo/logonobg.png" alt="Logo" class="mb-3" style="height: 100px;">
                        <h4>Login</h4>
                    </div>
                   <form method="POST" action="{{ route('login') }}" class="p-4 border rounded bg-light">
    @csrf

    {{-- Email / Username --}}
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Email Address or Username') }}</label>
        <input id="email" type="text"
               class="form-control @error('email') is-invalid @enderror"
               name="email" value="{{ old('email') }}" required autofocus>

        @error('email')
            <span class="invalid-feedback d-block">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">{{ __('Password') }}</label>
        <input id="password" type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password" required>

        @error('password')
            <span class="invalid-feedback d-block">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    {{-- Remember Me --}}
    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember"
               {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">
            {{ __('Remember Me') }}
        </label>
    </div>

    {{-- Login Button --}}
    <div class="mb-3">
        <button type="submit" class="btn btn-primary w-100">
            {{ __('Login') }}
        </button>
    </div>

    {{-- Links --}}
    <div class="d-flex justify-content-between">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
        @endif

        <a href="{{ route('register') }}">{{ __('Create Account') }}</a>
    </div>
</form>


                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Show/Hide Password JS -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("passwordInput");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            }
        }
    </script>
</body>

</html>
