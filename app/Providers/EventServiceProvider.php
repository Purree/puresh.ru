<?php

namespace App\Providers;

use App\Listeners\LogFailedAuthAttempt;
use App\Listeners\LogNewUserRegistration;
use App\Listeners\LogUserLogin;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            LogNewUserRegistration::class,
        ],
        Login::class => [
            LogUserLogin::class,
        ],
        Failed::class => [
            LogFailedAuthAttempt::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
