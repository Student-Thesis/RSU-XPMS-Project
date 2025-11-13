<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Proposal Submission - Stylique</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
            padding: 1.5rem;
        }

        .auth-btn {
            background: linear-gradient(to right, #f44336, #2196f3, #4caf50, #ffeb3b);
            background-size: 200%;
            color: #fff;
            border: none;
            transition: background-position 0.3s ease;
            text-align: center;
            display: block;
        }

        .auth-btn:hover {
            background-position: right center;
            color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }

        .form-section-title {
            font-weight: 600;
            margin-top: 25px;
            margin-bottom: 10px;
            color: #333;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card">
                        <h2 class="mb-3">Thank You!</h2>
                        <p class="lead">Your application has been received.
                            Our admin will review your submission and get back to you shortly.</p>

                        <div class="d-grid mt-4">
                            <a href="{{ url('/') }}" class="btn btn-success">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
