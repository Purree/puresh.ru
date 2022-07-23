<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Fortify\Fortify;

class LogFailedAuthAttempt implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        \Log::warning(
            'Failed auth attempt: '.(
                $event->user?->getAuthIdentifier() ??
                ('Login not existed, attempt: '.$event->credentials[Fortify::username()])).' '.
            'credentials: '.$event->credentials['password']
        );
    }
}
