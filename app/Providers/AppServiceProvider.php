<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        // CUSTOMIZE THE RESET URL INSTEAD USING THE BUILT IN DEFAULT URL
        ResetPassword::createUrlUsing( function (User $user , string $token) {
            return config('app.CLIENT_APP_URL').'/reset-password?token='. urlencode($token). '&email='. urlencode($user->email);
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()->id ?: $request->ip());
        });
    }
}
