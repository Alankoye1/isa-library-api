<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        // Runtime switch stored in cache. Defaults to ON.
        $enabled = fn () => (bool) Cache::get('rate_limit.enabled', true);

        // 5 requests/minute per IP on login and register.
        RateLimiter::for('auth', fn (Request $r) => $enabled()
            ? Limit::perMinute(5)->by($r->ip())
            : Limit::none());

        // 60 requests/minute per user (or per IP for guests).
        RateLimiter::for('api', fn (Request $r) => $enabled()
            ? Limit::perMinute(60)->by($r->user()?->id ?: $r->ip())
            : Limit::none());
    }
}
