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
                        <img src="images/logo/logonobg.png" alt="Logo" class="mb-3" style="height: 100px;">
                        <h4>New here?</h4>
                        <p class="text-muted">Signing up is easy. It only takes a few steps.</p>
                    </div>
                    <form method="POST" action="{{ route('register') }}" class="p-4 border rounded bg-light">
                        @csrf

                        {{-- Username --}}
                        <div class="mb-3">
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror" placeholder="Username"
                                value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- College --}}
                        <div class="mb-3">
                            <select name="college" class="form-select @error('college') is-invalid @enderror" required>
                                <option value="" disabled {{ old('college') ? '' : 'selected' }}>College</option>
                                @foreach (['CAS', 'CBA', 'CET', 'CAFES', 'CCMADI', 'CED', 'GEPS', 'CALATRAVA CAMPUS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS', 'SAN ANDRES CAMPUS', 'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS', 'CAJIDIOCAN CAMPUS', 'SAN FERNANDO CAMPUS'] as $opt)
                                    <option value="{{ $opt }}" {{ old('college') === $opt ? 'selected' : '' }}>
                                        {{ $opt }}</option>
                                @endforeach
                            </select>
                            @error('college')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password + toggle --}}
                        <div class="mb-3 position-relative">
                            <input type="password" name="password" id="passwordInput"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                minlength="8" required>
                            <button type="button"
                                class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2"
                                style="border:none;background:transparent" onclick="togglePassword()">
                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                            </button>
                            <div id="passwordFeedback" class="text-danger small mt-1 d-none">
                                Password must be at least 8 characters.
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm Password" required>
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid mb-3">
                            <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Next</button>
                        </div>




                        {{-- Already have an account --}}
                        <div class="text-center">
                            <small>
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-primary fw-bold">Login</a>
                            </small>
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

    <script>
        const passwordInput = document.getElementById("passwordInput");
        const submitBtn = document.getElementById("submitBtn");
        const feedback = document.getElementById("passwordFeedback");

        passwordInput.addEventListener("input", function() {
            if (passwordInput.value.length < 8) {
                passwordInput.classList.add("is-invalid");
                feedback.classList.remove("d-none");
                submitBtn.disabled = true;
            } else {
                passwordInput.classList.remove("is-invalid");
                feedback.classList.add("d-none");
                submitBtn.disabled = false;
            }
        });

        function togglePassword() {
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
