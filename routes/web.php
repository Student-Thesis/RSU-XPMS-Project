<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentPermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingsClassificationController;
use App\Http\Controllers\SettingsTargetAgendaController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/auth-register', [App\Http\Controllers\HomeController::class, 'register'])->name('auth.register');

Route::middleware(['auth'])->group(function () {
    // Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users')->middleware('deptperm:Users,view');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/proposals', [App\Http\Controllers\ProposalController::class, 'register'])->name('proposals.index');
    Route::post('/proposals', [App\Http\Controllers\ProposalController::class, 'store'])->name('proposals.store');

    Route::get('/agreement', [App\Http\Controllers\AgreementController::class, 'register'])->name('agreement.register');
    Route::post('/agreement', [App\Http\Controllers\AgreementController::class, 'store'])->name('agreement.store');
    Route::get('/notif-agreement', [App\Http\Controllers\NotificationsController::class, 'agreement'])->name('notifications.agreement');

    Route::get('/departments/permissions', [DepartmentPermissionController::class, 'index'])->name('departments.permissions.index');
    Route::post('/departments/permissions', [DepartmentPermissionController::class, 'store'])->name('departments.permissions.store');
    Route::get('/departments/{department}/permissions', [DepartmentPermissionController::class, 'edit'])->name('departments.permissions.edit');
    Route::put('/departments/{department}/permissions', [DepartmentPermissionController::class, 'update'])->name('departments.permissions.update');

    Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
    Route::get('/forms/create', [FormController::class, 'create'])->name('forms.create');
    Route::post('/forms', [FormController::class, 'store'])->name('forms.store');
    Route::get('/forms/{form}/edit', [FormController::class, 'edit'])->name('forms.edit');
    Route::put('/forms/{form}', [FormController::class, 'update'])->name('forms.update');
    Route::delete('/forms/{form}', [FormController::class, 'destroy'])->name('forms.destroy');

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::get('/help', [App\Http\Controllers\HelpController::class, 'index'])->name('help');
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages');
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::patch('/projects/{project}/inline', [ProjectController::class, 'inlineUpdate'])->name('projects.inline');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::get('/faculty', [App\Http\Controllers\FacultyController::class, 'index'])->name('faculty');

    Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // routes/web.php
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/load', [NotificationController::class, 'load'])->name('notifications.load');

    Route::resource('settings_classifications', SettingsClassificationController::class);
    Route::patch('settings_classifications/{settings_classification}/toggle', [SettingsClassificationController::class, 'toggle'])->name('settings_classifications.toggle');
    Route::get('api/settings_classifications', [SettingsClassificationController::class, 'listJson'])->name('settings_classifications.listJson');

    Route::resource('settings_target_agendas', SettingsTargetAgendaController::class);
    Route::get('api/settings_target_agendas', [SettingsTargetAgendaController::class, 'listJson'])->name('settings_target_agendas.listJson');
});
