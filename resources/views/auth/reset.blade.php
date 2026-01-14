<!DOCTYPE html>
<html>
<head>
    <title>Request Password Reset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;

            /* Animated Gradient */
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
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.2);
        }
    </style>
</head>

<body>

<div class="card p-4 col-md-4 col-11">
    <div class="text-center mb-4">
        <img src="{{ $basePath }}/images/logo/logonobg.png" alt="Logo" class="mb-3" style="height: 100px;">
    </div>

    <h3 class="text-center mb-3">Reset Password</h3>
    <p class="text-center text-muted">Enter your email to receive a 6-digit verification code.</p>

    <form method="POST" action="{{ route('pass.sendCode.custom') }}" id="sendCodeForm">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>

            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100" id="sendCodeBtn">
            Send Code
        </button>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('sendCodeForm');
        const btn  = document.getElementById('sendCodeBtn');

        if (!form) return;

        form.addEventListener('submit', function () {
            // optional: disable button to prevent double-click
            if (btn) {
                btn.disabled = true;
            }

            if (window.Swal) {
                Swal.fire({
                    title: 'Sending code...',
                    text: 'Please wait while we send the verification code.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
            // no preventDefault — let the form submit normally
        });
    });
</script>

</body>
</html>
