<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Sign Up - Stylique</title>

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
            <h4>New here?</h4>
            <p class="text-muted">Signing up is easy. It only takes a few steps.</p>
          </div>
          <form>
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
              <select class="form-select" required>
                <option disabled selected>College</option>
                <option>CAS</option>
                <option>CBA</option>
                <option>CET</option>
                <option>CAFES</option>
                <option>CCMADI</option>
                <option>CED</option>
                <option>GEPS</option>
                <option>CALATRAVA CAMPUS</option>
                <option>STA. MARIA CAMPUS</option>
                <option>SANTA FE CAMPUS</option>
                <option>SAN ANDRES CAMPUS</option>
                <option>SAN AGUSTIN CAMPUS</option>
                <option>ROMBLON CAMPUS</option>
                <option>CAJIDIOCAN CAMPUS</option>
                <option>SAN FERNANDO CAMPUS</option>
              </select>
        
             </div>
            <div class="mb-3 password-wrapper">
              <input type="password" class="form-control" id="passwordInput" placeholder="Password" required>
              <button type="button" class="toggle-password" onclick="togglePassword()">
                <i class="bi bi-eye-slash" id="toggleIcon"></i>
              </button>
            </div>
            <div class="d-grid mb-3">
              <a href="Register.html" class="btn auth-btn text-center">Next</a>
            </div>

            <div class="text-center">
              <small>Already have an account? <a href="{{route('login')}}" class="text-primary fw-bold">Login</a></small>
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