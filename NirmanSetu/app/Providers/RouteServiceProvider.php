<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The default path to redirect to after login if role is not used.
     */
    public const HOME = '/dashboard';

    /**
     * Redirect user based on role after login.
     */
    public static function redirectBasedOnRole(): string
    {
        $user = auth()->user();

        if (!$user || !$user->role) {
            return self::HOME; // fallback
        }

        return match ($user->role) {
            'admin' => '/admin/dashboard',
            'engineer' => '/engineer/dashboard',
            'manager' => '/manager/dashboard',
            default => self::HOME,
        };
    }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
