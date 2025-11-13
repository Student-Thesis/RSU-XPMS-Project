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
    </style>

</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo/logonobg.png') }}" alt="Logo" class="mb-3"
                            style="height: 100px;">
                        <h4>New here?</h4>
                        <p class="text-muted">Signing up is easy. It only takes a few steps.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="p-4 border rounded bg-light">
                        @csrf

                        {{-- First / Last Name --}}
                        <div class="row g-2 mb-3">
                            <div class="col">
                                <input type="text" name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    placeholder="First name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col">
                                <input type="text" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    placeholder="Last name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

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

                        {{-- Phone --}}
                        <div class="mb-3">
                            <input type="text" name="phone"
                                class="form-control @error('phone') is-invalid @enderror" placeholder="Phone (optional)"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- College --}}
                        <div class="mb-3">
                            <select name="college" class="form-select @error('college') is-invalid @enderror" required>
                                <option value="" disabled {{ old('college') ? '' : 'selected' }}>College</option>
                                @foreach (['CAS', 'CBA', 'CET', 'CAFES', 'CCMADI', 'CED', 'GEPS', 'CALATRAVA CAMPUS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS', 'SAN ANDRES CAMPUS', 'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS', 'CAJIDIOCAN CAMPUS', 'SAN FERNANDO CAMPUS'] as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('college') === $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                            @error('college')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Roles --}}
                        <div class="mb-3">
                            <select name="department_id" id="department_id"
                                class="form-select @error('department_id') is-invalid @enderror" required>
                                <option value="" disabled {{ old('department_id') ? '' : 'selected' }}>Select
                                    Roles</option>
                                <option value="2" {{ old('department_id') == 2 ? 'selected' : '' }}>Project Leader
                                </option>
                                <option value="3" {{ old('department_id') == 3 ? 'selected' : '' }}>Coordinator
                                </option>
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <input type="password" name="password" id="passwordInput"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                minlength="8" required>

                            <div id="passwordFeedback" class="text-danger small mt-1 d-none">
                                Password must be at least 8 characters.
                            </div>

                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Show Password --}}
                        <div class="mb-3">
                            <input type="checkbox" id="showPassword" onclick="togglePassword()">
                            <label for="showPassword">Show Password</label>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm Password" required>
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid mb-3">
                            <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Register</button>
                        </div>

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


    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
            passwordInput.type =
                passwordInput.type === "password" ? "text" : "password";
        }
    </script>

    <style>
        /* Remove Chrome autofill background + keep text color normal */
        input.form-control:-webkit-autofill,
        input.form-control:-webkit-autofill:hover,
        input.form-control:-webkit-autofill:focus,
        input.form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
            box-shadow: 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: #212529 !important;
            color: #212529 !important;
            transition: background-color 9999s ease-in-out 0s;
        }

        /* For select autofill (if ever triggered) */
        select.form-select:-webkit-autofill,
        select.form-select:-webkit-autofill:hover,
        select.form-select:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: #212529 !important;
        }

        /* Ensure the input border does not darken on autofill */
        input.form-control,
        select.form-select {
            background-color: #fff !important;
            color: #212529 !important;
        }
    </style>
</body>

</html>
