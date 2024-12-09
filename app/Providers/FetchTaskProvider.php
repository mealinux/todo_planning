<?php

namespace App\Providers;

use App\Services\ApiService;
use App\Services\FetchTaskService;
use Illuminate\Support\ServiceProvider;

class FetchTaskProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FetchTaskService::class, function ($app) {
            return new FetchTaskService(config('todo.schema'), $app->make(ApiService::class));
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
