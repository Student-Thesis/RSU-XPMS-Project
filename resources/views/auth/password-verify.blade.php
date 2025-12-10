<!DOCTYPE html>
<html>
<head>
    <title>Verify Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        background: linear-gradient(135deg, #f44336, #2196f3, #4caf50, #ffeb3b);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;

        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .card-custom {
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0px 6px 20px rgba(0,0,0,0.25);
        background: #ffffffd9;
        backdrop-filter: blur(4px);
    }

    h3 {
        font-weight: 600;
    }
</style>

<body>

<div class="container col-md-4">
    <div class="card card-custom">

        <h3 class="text-center mb-3">Verify Code</h3>
        <p class="text-center text-muted">
            A 6-digit verification code was sent to <strong>{{ $email }}</strong>.
        </p>

        <form method="POST" action="{{ route('password.reset.custom') }}">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-3">
                <label>Verification Code</label>
                <input type="text" name="code" class="form-control" maxlength="6" required>
                @error('code')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-success w-100">Reset Password</button>
        </form>

    </div>
</div>

</body>
</html>
