<?php

namespace App\Providers;

use App\Services\FetchTodoService;
use Illuminate\Support\ServiceProvider;

class FetchTodoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FetchTodoService::class, function ($app) {
            return new FetchTodoService(config('todo.schema'));
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
