<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Auth\LoginService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoginService::class, function ($app) {
            return new LoginService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
