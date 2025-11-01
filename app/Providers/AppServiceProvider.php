<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Schema;

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
        // if you're serving from subfolder
        $basePath = request()->ip() === '127.0.0.1' ? '' : '/public';
        View::share('basePath', $basePath);

        // 🔔 Share notifications only if table exists
        if (Schema::hasTable('activity_logs')) {
            // better to bind to topnav only, not all views
            View::composer('layouts.partials.topnav', function ($view) {
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
}
