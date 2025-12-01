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

        /* Autofill Fix */
        input.form-control:-webkit-autofill,
        input.form-control:-webkit-autofill:hover,
        input.form-control:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #fff inset !important;
            -webkit-text-fill-color: #212529 !important;
            transition: background-color 9999s ease-in-out 0s;
        }

        /* Login button */
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
    </style>
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

                <div class="card p-4">
                    <div class="text-center mb-4">
                        <img src="/images/logo/logonobg.png" alt="Logo" class="mb-3" style="height: 100px;">
                        <h4>Login</h4>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="p-4 border rounded bg-light">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
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
                        <div class="mb-2">
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
                            <input type="checkbox" id="showPassword" onclick="togglePassword()">
                            <label for="showPassword">Show Password</label>
                        </div>

                        {{-- Simple CAPTCHA --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Security Check:
                                <span id="captchaQuestion" class="fw-semibold"></span>
                            </label>
                            <input type="number" id="captchaAnswer" class="form-control" placeholder="Enter answer here">
                            <div id="captchaFeedback" class="form-text text-danger d-none">
                                Incorrect answer. Please try again.
                            </div>
                        </div>

                        {{-- Login Button --}}
                        <div class="mb-3">
                            <button type="submit" id="loginBtn" class="btn auth-btn w-100" disabled>
                                Login
                            </button>
                        </div>

                        {{-- Links --}}
                        <div class="d-flex justify-content-between">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                            @endif

                            <a href="{{ route('register') }}">Create Account</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            input.type = input.type === "password" ? "text" : "password";
        }

        // === Simple Math CAPTCHA ===
        let captchaCorrectAnswer = null;

        function generateCaptcha() {
            const a = Math.floor(Math.random() * 10) + 1;   // 1–10
            const b = Math.floor(Math.random() * 10) + 1;   // 1–10
            captchaCorrectAnswer = a + b;

            const questionSpan = document.getElementById('captchaQuestion');
            if (questionSpan) {
                questionSpan.textContent = `What is ${a} + ${b}?`;
            }

            // reset states
            const answerInput   = document.getElementById('captchaAnswer');
            const loginBtn      = document.getElementById('loginBtn');
            const feedback      = document.getElementById('captchaFeedback');

            if (answerInput) answerInput.value = '';
            if (loginBtn)    loginBtn.disabled = true;
            if (feedback)    feedback.classList.add('d-none');
        }

        function validateCaptcha() {
            const answerInput = document.getElementById('captchaAnswer');
            const loginBtn    = document.getElementById('loginBtn');
            const feedback    = document.getElementById('captchaFeedback');

            if (!answerInput || !loginBtn) return;

            const userAnswer = parseInt(answerInput.value, 10);

            if (!isNaN(userAnswer) && userAnswer === captchaCorrectAnswer) {
                loginBtn.disabled = false;
                if (feedback) feedback.classList.add('d-none');
            } else {
                loginBtn.disabled = true;
                if (feedback && answerInput.value !== '') {
                    feedback.classList.remove('d-none');
                } else if (feedback) {
                    feedback.classList.add('d-none');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            generateCaptcha();

            const answerInput = document.getElementById('captchaAnswer');
            if (answerInput) {
                answerInput.addEventListener('input', validateCaptcha);
            }
        });
    </script>

</body>
</html>
