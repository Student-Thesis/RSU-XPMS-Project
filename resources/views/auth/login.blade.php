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

    <!-- Cloudflare Turnstile -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    <!-- Custom Styling -->
    <style>
        body {
            background: linear-gradient(135deg, #f44336, #2196f3, #4caf50, #ffeb3b);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card {
            background-color: #ffffffcc;
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .auth-btn {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 0.75rem;
            border-radius: 0.35rem;
            font-weight: 600;
            transition: 0.25s ease-in-out;
        }

        .auth-btn:hover {
            background: #0056b3;
            box-shadow: 0 0.4rem 1rem rgba(0, 0, 0, 0.25);
            color: #fff;
        }

        /* Make Turnstile fit on mobile */
        .cf-turnstile {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            {{-- Global error (if any) --}}
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card p-4">

                <div class="text-center mb-4">
                    <img src="{{ $basePath }}/images/logo/logonobg.png"
                         alt="Logo"
                         class="mb-3"
                         style="height: 100px;">
                    <h4>Login</h4>
                </div>

                <form method="POST" action="{{ route('login') }}" class="p-4 border rounded bg-light">
                    @csrf

                    {{-- Email --}}
                   <div class="mb-3">
    <label for="email" class="form-label">Email Address</label>

    <input
        id="email"
        type="text"
        name="email"
        value="{{ old('email') }}"
        required
        autofocus
        class="form-control @error('email') is-invalid @enderror"
        style="text-transform: lowercase;"
        oninput="this.value = this.value.toLowerCase();"
    >

    @error('email')
        <span class="invalid-feedback d-block">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required>

                        @error('password')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- Show Password --}}
                    <div class="mb-3">
                        <input type="checkbox" id="showPassword">
                        <label for="showPassword">Show Password</label>
                    </div>

                    {{-- ✅ TURNSTILE (replaces captcha image) --}}
                    <div class="mb-3">
                        <label class="form-label">Security Check</label>

                        <div class="cf-turnstile"
                             data-sitekey="{{ config('services.turnstile.site_key') }}">
                        </div>

                        {{-- Turnstile errors --}}
                        @if ($errors->has('captcha'))
                            <div class="text-danger small mt-2">
                                {{ $errors->first('captcha') }}
                            </div>
                        @endif
                    </div>

                    {{-- Login Button --}}
                    <div class="mb-3">
                        <button type="submit" class="btn auth-btn w-100">Login</button>
                    </div>

                    {{-- Links --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('password.request.custom') }}">Forgot Password?</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Create Account</a>
                        @endif
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Show / hide password
    document.getElementById('showPassword').addEventListener('change', function () {
        const input = document.getElementById('password');
        input.type = this.checked ? 'text' : 'password';
    });
</script>

</body>
</html>
