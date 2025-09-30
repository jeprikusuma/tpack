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
        // Gate for mahasiswa
        Gate::define('mahasiswa', function ($user = null) {
            return auth()->check() && auth()->user()->role === 'mahasiswa';
        });

        // Gate for dosen
        Gate::define('dosen', function ($user = null) {
            return auth()->check() && auth()->user()->role === 'dosen';
        });
    }
}
