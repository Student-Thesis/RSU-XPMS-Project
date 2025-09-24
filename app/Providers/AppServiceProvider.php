<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Support\DeptCan;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::if('deptcan', function (string $slug) {
            return DeptCan::check(auth()->user(), $slug);
        });

        View::composer('*', function ($view) {
            $view->with('department', auth()->user()?->department);
        });
    }
}
