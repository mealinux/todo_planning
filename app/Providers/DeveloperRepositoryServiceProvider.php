<?php

namespace App\Providers;

use App\Repositories\DeveloperRepository;
use Illuminate\Support\ServiceProvider;

class DeveloperRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('developerRepository', function ($app) {
            return new DeveloperRepository();
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
