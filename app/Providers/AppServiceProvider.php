<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        // Gates
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('admin-or-medico', function ($user) {
            return in_array($user->role, ['admin', 'medico']);
        });

        Gate::define('medico', function ($user) {
            return $user->role === 'medico';
        });

        Gate::define('admin-or-mAdmin', function($user){
            return $user->role === 'admin' || $user->permissions === 'mAdmin';
        });

        Gate::define('paciente', function ($user) {
            return $user->role === 'paciente';
        });
    }
}
