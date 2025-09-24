<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentPermissionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
// Route::middleware(['auth'])->group(function () {
    Route::get('/auth-register', [App\Http\Controllers\HomeController::class, 'register'])->name('auth.register');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::get('/help', [App\Http\Controllers\HelpController::class, 'index'])->name('help');
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages');
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');

    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects');
    Route::get('/forms', [App\Http\Controllers\FormController::class, 'index'])->name('forms');
    Route::get('/faculty', [App\Http\Controllers\FacultyController::class, 'index'])->name('faculty');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');

    Route::middleware(['dept.perm:permissions.manage'])->group(function () {
        Route::get('/departments/{department}/permissions', [DepartmentPermissionController::class, 'edit'])->name('departments.permissions.edit');
        Route::put('/departments/{department}/permissions', [DepartmentPermissionController::class, 'update'])->name('departments.permissions.update');
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('web')
    ->name('logout');
// });
