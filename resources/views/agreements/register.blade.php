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
                    <h4 class="text-center mb-4">Proposal Submission Form</h4>

                    <form action="{{ route('agreement.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Organization Name</label>
                            <input type="text" name="organization_name" class="form-control"
                                placeholder="Enter organization name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date Signed</label>
                            <input type="date" name="date_signed" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">MOU Document</label>
                            <input type="file" name="mouFile" class="form-control"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">MOA Document</label>
                            <input type="file" name="moaFile" class="form-control"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn auth-btn">Submit Documents</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
