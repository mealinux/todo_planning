<?php

namespace App\Providers;

use App\Services\ErrorHandlingService;
use Illuminate\Support\ServiceProvider;

class ErrorHandlingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('errorHandlingService', function ($app) {
            return new ErrorHandlingService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
