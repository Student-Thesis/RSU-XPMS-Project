<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentPermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingsClassificationController;
use App\Http\Controllers\SettingsTargetAgendaController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\CalendarController; 
use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\SettingsController; 
use App\Http\Controllers\NotificationsController; 
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\EventLocationController;

Route::get('/', function () { 
    return view('auth.login');
});

// Show Reset Password Request (email input)
Route::get('/pass/reset', [App\Http\Controllers\Auth\ResetController::class, 'showEmailForm'])->name('password.request.custom');
Route::post('/pass/send-code', [App\Http\Controllers\Auth\ResetController::class, 'sendCode'])->name('pass.sendCode.custom');
Route::get('/pass/verify', [App\Http\Controllers\Auth\ResetController::class, 'showVerifyForm'])->name('password.verify.custom');
Route::post('/pass/reset', [App\Http\Controllers\Auth\ResetController::class, 'resetPassword'])->name('password.reset.custom');


Route::get('/captcha/refresh', function () {
    return response()->json([
        'captcha' => captcha_src('default'),
    ]);
})->name('captcha.refresh');


Auth::routes();

/* ================== REGISTRATION PROCESS ================== */
Route::get('/auth-register', [App\Http\Controllers\HomeController::class, 'register'])->name('auth.register');
Route::get('/proposals',  [ProposalController::class, 'register'])->name('proposals.index');
Route::post('/proposals', [ProposalController::class, 'store'])->name('proposals.store');
Route::get('/agreement',        [AgreementController::class, 'register'])->name('agreement.register');
Route::post('/agreement',       [AgreementController::class, 'store'])->name('agreement.store');
Route::get('/notif-agreement',  [NotificationsController::class, 'agreement'])->name('notifications.agreement');


Route::middleware(['auth'])->group(function () {

    /* ================== USERS ================== */
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/',             [UserController::class, 'index'])->middleware('dept.can:users,view')->name('index');
        Route::get('/create',       [UserController::class, 'create'])->middleware('dept.can:users,create')->name('create');
        Route::post('/',            [UserController::class, 'store'])->middleware('dept.can:users,create')->name('store');
        Route::get('/{user}/edit',  [UserController::class, 'edit'])->middleware('dept.can:users,update')->name('edit');
        Route::put('/{user}',       [UserController::class, 'update'])->middleware('dept.can:users,update')->name('update');
        Route::delete('/{user}',    [UserController::class, 'destroy'])->middleware('dept.can:users,delete')->name('destroy');
    });

    /* ================== PROPOSALS ================== */
   Route::post('/proposals/{id}/approve', [ProposalController::class, 'approve'])
        ->name('proposals.approve');

    /* ================== AGREEMENT / NOTIF ================== */
   


    /* ================== DEPARTMENT PERMISSIONS ================== */
    Route::prefix('departments/permissions')->name('departments.permissions.')->group(function () {
        Route::get('/',                    [DepartmentPermissionController::class, 'index'])->middleware('dept.can:users,view')->name('index');
        Route::post('/',                   [DepartmentPermissionController::class, 'store'])->middleware('dept.can:users,create')->name('store');
        Route::get('{department}',         [DepartmentPermissionController::class, 'show'])->middleware('dept.can:users,view')->name('show');
        Route::get('{department}/edit',    [DepartmentPermissionController::class, 'edit'])->middleware('dept.can:users,update')->name('edit');
        Route::put('{department}',         [DepartmentPermissionController::class, 'update'])->middleware('dept.can:users,update')->name('update');
        Route::delete('{dept_permission}', [DepartmentPermissionController::class, 'destroy'])->middleware('dept.can:users,delete')->name('destroy');

        // =================== USER-LEVEL PERMISSIONS ===================
Route::get('user/{user}/edit', [DepartmentPermissionController::class, 'editUser'])
    ->middleware('dept.can:users,update')
    ->name('user.edit');

Route::put('user/{user}', [DepartmentPermissionController::class, 'updateUser'])
    ->middleware('dept.can:users,update')
    ->name('user.update');

    });

    /* ================== FORMS ================== */
    Route::prefix('forms')->name('forms.')->group(function () {
        Route::get('/',            [FormController::class, 'index'])->middleware('dept.can:forms,view')->name('index');
        Route::get('/create',      [FormController::class, 'create'])->middleware('dept.can:forms,create')->name('create');
        Route::post('/',           [FormController::class, 'store'])->middleware('dept.can:forms,create')->name('store');
        Route::get('/{form}/edit', [FormController::class, 'edit'])->middleware('dept.can:forms,update')->name('edit');
        Route::put('/{form}',      [FormController::class, 'update'])->middleware('dept.can:forms,update')->name('update');
        Route::delete('/{form}',   [FormController::class, 'destroy'])->middleware('dept.can:forms,delete')->name('destroy');
    });

    /* ================== DASHBOARD / STATIC PAGES ================== */
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/settings',  [SettingsController::class, 'index'])->middleware('dept.can:settings,view')->name('settings');
    Route::get('/help',      [HelpController::class, 'index'])->name('help');
    Route::get('/messages',  [MessagesController::class, 'index'])->middleware('dept.can:messages,view')->name('messages');
    Route::post('/messages/public', [MessagesController::class, 'storePublic'])->name('messages.public.store');
    Route::post('/messages/private', [MessagesController::class, 'storePrivate'])->name('messages.private.store');
    Route::get('/proposals/{proposal}/json', [MessagesController::class, 'showJson'])->name('proposals.showJson');

    /* ================== NOTIFICATIONS ================== */
    Route::get('/notifications',      [NotificationController::class, 'index'])->middleware('dept.can:notifications,view')->name('notifications');
    Route::get('/notifications/load', [NotificationController::class, 'load'])->middleware('dept.can:notifications,view')->name('notifications.load');

    /* ================== PROJECTS ================== */
    Route::prefix('projects')->group(function () {
        Route::get('/',                   [ProjectController::class, 'index'])->middleware('dept.can:project,view')->name('projects');
        Route::post('/{project}/inline', [ProjectController::class, 'inlineUpdate'])->middleware('dept.can:project,update')->name('projects.inline-update');
        Route::get('/create',             [ProjectController::class, 'create'])->middleware('dept.can:project,create')->name('projects.create');
        Route::post('/',                  [ProjectController::class, 'store'])->middleware('dept.can:project,create')->name('projects.store');
        Route::get('/{project}/edit',     [ProjectController::class, 'edit'])->middleware('dept.can:project,update')->name('projects.edit');
        Route::put('/{project}',          [ProjectController::class, 'update'])->middleware('dept.can:project,update')->name('projects.update');
        Route::delete('/{project}',       [ProjectController::class, 'destroy'])->middleware('dept.can:project,delete')->name('projects.destroy'); 
    });

    /* ================== FACULTIES ================== */
    Route::prefix('faculties')->name('faculties.')->group(function () {
        Route::get('/',               [FacultyController::class, 'index'])->middleware('dept.can:faculty,view')->name('index');
        Route::get('/create',         [FacultyController::class, 'create'])->middleware('dept.can:faculty,create')->name('create');
        Route::post('/',              [FacultyController::class, 'store'])->middleware('dept.can:faculty,create')->name('store');
        Route::get('/{faculty}/edit', [FacultyController::class, 'edit'])->middleware('dept.can:faculty,update')->name('edit');
        Route::put('/{faculty}',      [FacultyController::class, 'update'])->middleware('dept.can:faculty,update')->name('update');
        Route::delete('/{faculty}',   [FacultyController::class, 'destroy'])->middleware('dept.can:faculty,delete')->name('destroy');
    });

    /* ================== CALENDAR ================== */
    // page
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    // JSON CRUD for FullCalendar
    Route::get('/calendar/events', [CalendarEventController::class, 'index'])->middleware('dept.can:calendar,view')->name('calendar.events.index');
    Route::post('/calendar/events', [CalendarEventController::class, 'store'])->middleware('dept.can:calendar,create')->name('calendar.events.store');
    Route::get('/calendar/events/{event}', [CalendarEventController::class, 'show'])->middleware('dept.can:calendar,create')->name('calendar.events.show');
    Route::put('/calendar/events/{event}', [CalendarEventController::class, 'update'])->middleware('dept.can:calendar,update')->name('calendar.events.update');
    Route::delete('/calendar/events/{event}', [CalendarEventController::class, 'destroy'])->middleware('dept.can:calendar,delete')->name('calendar.events.destroy'); 

    /* ================== PROFILE ================== */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /* ================== SETTINGS RESOURCES ================== */
    Route::resource('settings_classifications', SettingsClassificationController::class)->middleware('dept.can:settings,update');
    Route::patch('settings_classifications/{settings_classification}/toggle',[SettingsClassificationController::class, 'toggle'])->middleware('dept.can:settings,update')->name('settings_classifications.toggle');
    Route::get('api/settings_classifications',[SettingsClassificationController::class, 'listJson'])->middleware('dept.can:settings,view')->name('settings_classifications.listJson');
    Route::resource('settings_target_agendas', SettingsTargetAgendaController::class)->middleware('dept.can:settings,update');
    Route::get('api/settings_target_agendas',[SettingsTargetAgendaController::class, 'listJson'])->middleware('dept.can:settings,view')->name('settings_target_agendas.listJson');

    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead')->middleware('auth');


    Route::prefix('calendar/locations')->name('event-locations.')->group(function () {
        Route::get('/',           [EventLocationController::class, 'index'])->name('index');
        Route::get('/create',     [EventLocationController::class, 'create'])->name('create');
        Route::post('/',          [EventLocationController::class, 'store'])->name('store');
        Route::get('/{eventLocation}/edit', [EventLocationController::class, 'edit'])->name('edit');
        Route::put('/{eventLocation}',      [EventLocationController::class, 'update'])->name('update');
        Route::delete('/{eventLocation}',   [EventLocationController::class, 'destroy'])->name('destroy');
    });

  

});
