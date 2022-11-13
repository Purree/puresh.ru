<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->afterResolving(EmailVerificationNotificationController::class, function ($controller) {
            $controller->middleware('throttle:verification');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('components.language_switcher', static function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        RateLimiter::for('verification', static function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        RateLimiter::for('vk-linking', static function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });
    }
}
