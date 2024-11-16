<?php

namespace App\Providers;
use App\Models\User;
use App\Observers\UserObserver;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
          // Enregistre l'observer pour le modèle User
    User::observe(UserObserver::class);
    }
}
