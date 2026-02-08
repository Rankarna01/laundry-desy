<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // <--- JANGAN LUPA IMPORT INI
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Logika untuk mengecek Role
        Gate::define('role', function (User $user, $role) {
            return $user->role === $role;
        });
    }
}