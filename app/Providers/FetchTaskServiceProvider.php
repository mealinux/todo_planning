<?php

namespace App\Providers;

use App\Services\FetchTaskService;
use Illuminate\Support\ServiceProvider;

class FetchTaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('fetchTaskService', function ($app) {
            return new FetchTaskService(config('todo.schema'));
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
