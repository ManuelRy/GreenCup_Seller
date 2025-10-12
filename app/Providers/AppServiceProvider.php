<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Force HTTPS in production to fix "Network Error: Failed to fetch"
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
