# Laravel Installation (Blade Only, No NPM)
------------------------------------------------------------------------

## 1. Requirements

-   PHP \>= 8.2 with common extensions (ctype, curl, mbstring, pdo,
    tokenizer, xml, etc.).
-   Composer
-   Database (MySQL/MariaDB, PostgreSQL, SQLite, or SQL Server).

------------------------------------------------------------------------

## 2. Create a New Laravel App

``` bash
composer create-project laravel/laravel rsu-xpms-project
cd rsu-xpms-project
cp .env.example .env
php artisan key:generate
```

Configure `.env` for database:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=rsu_xpms_project
    DB_USERNAME=root
    DB_PASSWORD=

Run migrations:

``` bash
php artisan migrate
```

------------------------------------------------------------------------

## 3. Add Laravel UI for Auth (Blade Scaffolding)

``` bash
composer require laravel/ui
php artisan ui bootstrap --auth
```

This generates:

-   Authentication routes
-   Controllers
-   Blade views for login, register, password reset

------------------------------------------------------------------------

## 4. Layout with Bootstrap via CDN

Edit `resources/views/layouts/app.blade.php`:

``` blade
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
      <div class="ms-auto">
        @guest
          <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Login</a>
          <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Register</a>
        @else
          <span class="me-2">Hi, {{ Auth::user()->name }}</span>
          <a class="btn btn-outline-danger btn-sm" href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        @endguest
      </div>
    </div>
  </nav>

  <div class="container">
    @yield('content')
  </div>

  <!-- Bootstrap JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

------------------------------------------------------------------------

## 5. Routes

Ensure `routes/web.php` includes:

``` php
use Illuminate\Support\Facades\Auth;

Route::get('/', fn () => view('welcome'));
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
```

------------------------------------------------------------------------

## 6. Run the Application

``` bash
php artisan serve
```

Visit:

-   `/login`
-   `/register`
-   `/password/reset`

------------------------------------------------------------------------

## 7. Email Verification (Optional)

Enable in `User.php`:

``` php
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail {}
```

Protect routes:

``` php
Route::middleware(['auth', 'verified'])->get('/dashboard', fn () => view('dashboard'));
```

In `.env` for development:

    MAIL_MAILER=log

------------------------------------------------------------------------

## Done!
