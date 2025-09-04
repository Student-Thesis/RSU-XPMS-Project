<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

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

