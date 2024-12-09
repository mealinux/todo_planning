<?php

namespace App\Providers;

use App\Services\AssignTaskService;
use Illuminate\Support\ServiceProvider;

class AssignTaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('assignTaskService', function ($app) {
            return new AssignTaskService();
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
