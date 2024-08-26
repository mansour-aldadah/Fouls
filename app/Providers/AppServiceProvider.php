<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        Gate::define('superAdmins-admins-users-consumers', function ($user) {
            return $user->role === 'مدير أعلى' || $user->role === 'مدير' || $user->role === 'مستهلك' || $user->role === 'مستخدم';
        });
        Gate::define('superAdmins-admins-users', function ($user) {
            return $user->role === 'مدير أعلى' || $user->role === 'مدير' || $user->role === 'مستخدم';
        });
        Gate::define('superAdmins-admins', function ($user) {
            return $user->role === 'مدير أعلى' || $user->role === 'مدير';
        });
        Gate::define('superAdmins', function ($user) {
            return $user->role === 'مدير أعلى';
        });
        Gate::define('admins', function ($user) {
            return  $user->role === 'مدير';
        });
        Gate::define('admins-users', function ($user) {
            return $user->role === 'مستخدم' || $user->role === 'مدير';
        });
        Gate::define('users', function ($user) {
            return $user->role === 'مستخدم';
        });
        Gate::define('consumers', function ($user) {
            return $user->role === 'مستهلك';
        });
        Gate::define('users-consumers', function ($user) {
            return $user->role === 'مستهلك' || $user->role === 'مستخدم';
        });
        Gate::define('admins-consumers', function ($user) {
            return $user->role === 'مستهلك' || $user->role === 'مدير';
        });
    }
}
