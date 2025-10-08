<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App\Models\ActivityLog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $basePath = request()->ip() === '127.0.0.1' ? '' : '/public';
        View::share('basePath', $basePath);

        // ✅ Share first 5 notifications globally
        View::composer('*', function ($view) {
            $notifications = ActivityLog::with('user')
                ->latest()
                ->take(5)
                ->get();

            $notificationCount = ActivityLog::count();

            $view->with('notifications', $notifications)
                 ->with('notificationCount', $notificationCount);
        });
    }
}
