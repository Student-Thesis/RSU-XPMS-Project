<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentPermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/auth-register', [App\Http\Controllers\HomeController::class, 'register'])->name('auth.register');
Route::get('/proposals', [App\Http\Controllers\ProposalController::class, 'register'])->name('proposals.index');
Route::post('/proposals', [App\Http\Controllers\ProposalController::class, 'store'])->name('proposals.store');

Route::get('/agreement', [App\Http\Controllers\AgreementController::class, 'register'])->name('agreement.register');
Route::post('/agreement', [App\Http\Controllers\AgreementController::class, 'store'])->name('agreement.store');

Route::get('/notif-agreement', [App\Http\Controllers\NotificationsController::class, 'agreement'])->name('notifications.agreement');

Route::middleware(['auth'])->group(function () {
    // Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users')->middleware('deptperm:Users,view');
    Route::get('/users',            [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create',     [UserController::class, 'create'])->name('users.create');
    Route::post('/users',           [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit',[UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}',     [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',  [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/departments/permissions', [DepartmentPermissionController::class, 'index'])->name('departments.permissions.index')->middleware('deptperm:permissions,view');
    Route::post('/departments/permissions', [DepartmentPermissionController::class, 'store'])->name('departments.permissions.store')->middleware('deptperm:permissions,create');
    Route::get('/departments/{department}/permissions', [DepartmentPermissionController::class, 'edit'])->name('departments.permissions.edit')->middleware('deptperm:permissions,update');
    Route::put('/departments/{department}/permissions', [DepartmentPermissionController::class, 'update'])->name('departments.permissions.update')->middleware('deptperm:permissions,update');

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

    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects') ->middleware('deptperm:Projects,view');
    
    Route::get('/faculty', [App\Http\Controllers\FacultyController::class, 'index'])->name('faculty')->middleware('deptperm:Faculty,view');
   
    Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar')->middleware('deptperm:Calendar,view');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    
});
