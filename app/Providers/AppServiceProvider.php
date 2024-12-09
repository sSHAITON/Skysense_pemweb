<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Kreait\Firebase\Factory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('firebase.auth', function ($app) {
            return (new Factory)
                ->withServiceAccount(base_path('sister-fbece-firebase-adminsdk-5e238-05e16ea966.json'))
                ->createAuth();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('userprofilesettings', \App\View\Components\UserProfileSettings::class);
    }
}
